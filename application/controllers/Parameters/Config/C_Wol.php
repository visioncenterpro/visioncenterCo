<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_Wol extends Controller {

    public function __construct() {
        parent::__construct();
        $this->ValidateSession();
        $this->load->model("Parameters/Config/M_Wol");
        $data = $this->M_Wol->LoadParameters();

        $this->time_string = $data->seconds_on;
        $this->mac_address = $this->session->mac;
        $this->secureon = '';
        $this->addr = $this->session->ip;
        $this->cidr = $data->cidr;
        $this->port = $data->port;
        $this->store = "No";
    }

    public function index() {
        $result = $this->WakeOnLan();
        echo $result;
    }

    function WakeOnLan() {

        $a = date_create($this->time_string); // create date_object from $this->time_string
        $b = date_timezone_get($a); // create datetimezone_object from date_object

        if (!$b) {
            $error = "Error de entrada: la zona horaria es desconocida (no aparece en la base de datos de zona horaria de PHP en este servidor web).<br>\n";
            return $error;
        }

        $c = timezone_name_get($b); // get timezone abbreviaton from  datetimezone_object
        $d = timezone_name_from_abbr($c); // get timezone identifier from timezone abbreviation
        if ($d) {
            date_default_timezone_set($d);
        } else {
            date_default_timezone_set($c);
        }
        // Calculate $delay
        $time_script_start = time();
        $timestamp_new_send = strtotime($this->time_string);
        $delay = ($timestamp_new_send - $time_script_start);
        //Check whether $this->time_string is valid (value)
        if ($delay < 0) {
            $error = "Input error: Wake-up time is not set in the future.<br>\n";
            return $error; // false
        }
        // Force a minimum delay to prevent abuse (e.g., DOS-attacks)
        if ($delay < 3) {
            $delay = 3;
        }
        // Prepare magic packet: part 1/3 (defined constant)
        $buf = "";
        for ($a = 0; $a < 6; $a++)
            $buf .= chr(255); // the defined constant as represented in hexadecimal: FF FF FF FF FF FF (i.e., 6 bytes of hexadecimal FF)


            
//Check whether $this->mac_address is valid
        $this->mac_address = strtoupper($this->mac_address);
        $this->mac_address = str_replace(":", "-", $this->mac_address);
        if ((!preg_match("/([A-F0-9]{2}[-]){5}([0-9A-F]){2}/", $this->mac_address)) || (strlen($this->mac_address) != 17)) {
            $error = "Input error: Pattern of MAC-address is not \"xx-xx-xx-xx-xx-xx\" (x = digit or letter).<br>\n";
            return $error; // false
        } else {
            // Prepare magic packet: part 2/3 (16 times MAC-address)
            $this->addr_byte = explode('-', $this->mac_address); // Split MAC-address into an array of (six) bytes
            $hw_addr = "";
            for ($a = 0; $a < 6; $a++)
                $hw_addr .= chr(hexdec($this->addr_byte[$a])); // Convert MAC-address from bytes to hexadecimal to decimal
            $hw_addr_string = "";
            for ($a = 0; $a < 16; $a++)
                $hw_addr_string .= $hw_addr;
            $buf .= $hw_addr_string;
        }
        if ($this->secureon != "") {
            // Check whether $this->secureon is valid
            $this->secureon = strtoupper($this->secureon);
            $this->secureon = str_replace(":", "-", $this->secureon);
            if ((!preg_match("/([A-F0-9]{2}[-]){5}([0-9A-F]){2}/", $this->secureon)) || (strlen($this->secureon) != 17)) {
                $error = "Input error: Pattern of SecureOn-password is not \"xx-xx-xx-xx-xx-xx\" (x = digit or CAPITAL letter).<br>\n";
                return $error; // false
            } else {
                // Prepare magic packet: part 3/3 (Secureon password)
                $this->addr_byte = explode('-', $this->secureon); // Split MAC-address into an array of (six) bytes
                $hw_addr = "";
                for ($a = 0; $a < 6; $a++)
                    $hw_addr .= chr(hexdec($this->addr_byte[$a])); // Convert MAC address from hexadecimal to decimal
                $buf .= $hw_addr;
            }
        }
        // To support web proxy users
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $current_client_IP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $current_client_IP = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $current_client_IP = $_SERVER['REMOTE_ADDR'];
        }
        // Fill $this->addr with client's IP address, if $this->addr is empty
        if ($this->addr == "") {
            $this->addr = $current_client_IP;
        }
        // Resolve broadcast address
        if (filter_var($this->addr, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) { // same as (but easier than):  preg_match("/\b(([01]?\d?\d|2[0-4]\d|25[0-5])\.){3}([01]?\d?\d|2[0-4]\d|25[0-5])\b/",$this->addr)
            // $this->addr has an IP-adres format
        } else {
            // Whitespaces confuse name lookups
            $this->addr = trim($this->addr);
            // If you pass to gethostbyname() an:
            //	unresolvable domainname, gethostbyname() returns the domainname (rather than 'false')
            //	IP address, gethostbyname() returns that IP address.
            if (gethostbyname($this->addr) == $this->addr) {
                // $this->addr is NOT a resolvable domainname	
                $error = "Input error: host name of broadcast address is unresolvable.<br>\n";
                return $error; // false
            } else {
                // $this->addr IS a resolvable domainname
                $this->addr = gethostbyname($this->addr);
            }
        }
        // Store input value for cookie
        $resolved_addr = $this->addr;
        // If $this->cidr is set, replace $this->addr for its broadcast address
        if ($this->cidr != "") {
            // Check whether $this->cidr is valid
            if ((!ctype_digit($this->cidr)) || ($this->cidr < 0) || ($this->cidr > 32)) {
                $error = "Input error: CIDR subnet mask is not a number within the range of 0 till 32.<br>\n";
                return $error; // false
            }
            // Convert $this->cidr from one decimal to one inverted binary array
            $inverted_binary_cidr = "";
            for ($a = 0; $a < $this->cidr; $a++)
                $inverted_binary_cidr .= "0"; // Build $inverted_binary_cidr by $this->cidr * zeros (this is the mask)
            $inverted_binary_cidr = $inverted_binary_cidr . substr("11111111111111111111111111111111", 0, 32 - strlen($inverted_binary_cidr)); // Invert the mask (by postfixing ones to $inverted_binary_cidr untill 32 bits are filled/ complete)
            $inverted_binary_cidr_array = str_split($inverted_binary_cidr); // Convert $inverted_binary_cidr to an array of bits
            // Convert IP address from four decimals to one binary array
            $this->addr_byte = explode('.', $this->addr); // Split IP address into an array of (four) decimals
            $binary_addr = "";
            for ($a = 0; $a < 4; $a++) {
                $pre = substr("00000000", 0, 8 - strlen(decbin($this->addr_byte[$a]))); // Prefix zeros
                $post = decbin($this->addr_byte[$a]); // Postfix binary decimal
                $binary_addr .= $pre . $post;
            }
            $binary_addr_array = str_split($binary_addr); // Convert $binary_addr to an array of bits
            // Perform a bitwise OR operation on arrays ($binary_addr_array & $inverted_binary_cidr_array)
            $binary_broadcast_addr_array = "";
            for ($a = 0; $a < 32; $a++)
                $binary_broadcast_addr_array[$a] = ($binary_addr_array[$a] | $inverted_binary_cidr_array[$a]); // binary array of 32 bit variables ('|' = logical operator 'or')
            $binary_broadcast_addr = chunk_split(implode("", $binary_broadcast_addr_array), 8, "."); // build binary address of four bundles of 8 bits (= 1 byte)
            $binary_broadcast_addr = substr($binary_broadcast_addr, 0, strlen($binary_broadcast_addr) - 1); // chop off last dot ('.')
            $binary_broadcast_addr_array = explode(".", $binary_broadcast_addr); // binary array of 4 byte variables
            $broadcast_addr_array = "";
            for ($a = 0; $a < 4; $a++)
                $broadcast_addr_array[$a] = bindec($binary_broadcast_addr_array[$a]); // decimal array of 4 byte variables
            $this->addr = implode(".", $broadcast_addr_array); // broadcast address
        }
        // Check whether $this->port is valid
        if ((!ctype_digit($this->port)) || ($this->port < 0) || ($this->port > 65536)) {
            $error = "Input error: Port is not a number within the range of 0 till 65536.<br>\n";
            return $error; // false
        }
        // Check whether UDP is supported
        if (!array_search('udp', stream_get_transports())) {
            $error = "No magic packet can been sent, since UDP is unsupported (not a registered socket transport).<br>\n";
            return $error; // false
        }
        // COOKIE
        // Build contents of cookie
        $delimiter = "<->";
        $contents = "prefix" . $delimiter . $_SERVER['HTTP_USER_AGENT'] . $delimiter . $this->time_string . $delimiter . $this->mac_address . $delimiter . $this->secureon . $delimiter . $resolved_addr . $delimiter . $this->cidr . $delimiter . $this->port . $delimiter . $this->store . $delimiter . "postfix";

        $encrypted = $this->Encryption($contents);
        // Write cookie (31557600 seconds = 365,25 days which includes 1 leap day per 4 years)
        if ($this->store == "Yes") {
            setcookie("WOL", base64_encode($encrypted), time() + 31557600, "/");
        } else {
            setcookie("WOL", "", time() - 3600, "/");
        }
        // Display this value AFTER the header was sent and after the cookie was set
        //echo ($_SESSION['local_timezone_set']);
        unset($_SESSION['local_timezone_set']);
        // Simulate crontask behaviour
        ignore_user_abort(true); // so the user can not stop the script (running in background).
        set_time_limit(0); // parsing this script may take forever (no time limit is imposed)
// WHY_1?
        ob_start(); // ???
        ob_implicit_flush();
// WHY_1?
        //query_string
        $query_string = "";

        $post_variable[] = "time_string=" . $this->time_string;
        $post_variable[] = "mac_address=" . $this->time_string;
        $post_variable[] = "secureon=" . $this->secureon;
        $post_variable[] = "addr=" . $this->addr;
        $post_variable[] = "cidr=" . $this->cidr;
        $post_variable[] = "port=" . $this->port;
        $post_variable[] = "store=" . $this->store;
        $post_variable[] = "submit=Enviar petición";

        $query_string = "?" . join("&", $post_variable);
        // HTML-table
//        $pre_table =  "<table border=\"1\"><tr><th></th><th>dd-mm-yyyy</th><th>hh:mm:ss</th><th>timezone</th></tr>\n";
//        $pre_table = $pre_table . "<tr><td>Sleeping at</td><td>" . date("d-m-y", $time_script_start) . "</td><td>" . date("H:i:s", $time_script_start) . "</td><td>" . date("e", $time_script_start) . "</td></tr>\n";
//        $pre_table = $pre_table . "<tr><td>Will be resuming at</td><td>" . date("d-m-y", $time_script_start + $delay) . "</td><td>" . date("H:i:s", $time_script_start + $delay) . "</td><td>" . date("e", $time_script_start + $delay) . "</td></tr>\n";
//        echo ($pre_table);
        echo str_repeat(" ", 256); // Some versions of MS IE will only start to display the page, after they have received 256 bytes.
// WHY_2?
        ob_flush();
        flush();
        ob_end_clean(); // ???
// WHY_2?
        // SLEEP
        sleep($delay);
        // Wake up
        //$post_table = "<tr><td>Resumed at</td><td>" . date("d-m-y", time()) . "</td><td>" . date("H:i:s", time()) . "</td><td>" . date("e", time()) . "</td></tr></table>\n";
        //echo ($post_table);
        if (function_exists('fsockopen')) {
            // Try fsockopen function - To do: handle error 'Permission denied'
            $socket = fsockopen("udp://" . $this->addr, $this->port, $errno, $errstr);
            if ($socket) {
                $socket_data = fwrite($socket, $buf);
                if ($socket_data) {
                    $function = "fwrite";
                    $sent_fsockopen = "A magic packet of " . $socket_data . " bytes has been sent via UDP to IP address: " . $this->addr . ":" . $this->port . ", using the '" . $function . "()' function.<br>";
                    $content = bin2hex($buf);
                    $sent_fsockopen = $sent_fsockopen . "Contents of magic packet:<br><textarea rows=\"1\" name=\"content\" cols=\"" . strlen($content) . "\">" . $content . "</textarea><br>\n";
                    fclose($socket);
                    unset($socket);
                    //return $sent_fsockopen; // true
                    return "Enviado";
                } else {
                    echo "Using 'fwrite()' failed, due to error: '" . $errstr . "' (" . $errno . ")<br>\n";
                    fclose($socket);
                    unset($socket);
                }
            } else {
                echo "Using 'fsockopen()' failed, due to denied permission.<br>\n";
                unset($socket);
            }
        }
        // Try socket_create function
        if (function_exists('socket_create')) {
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP); // create socket based on IPv4, datagram and UDP
            if ($socket) {
                $level = SOL_SOCKET; // to enable manipulation of options at the socket level (you may have to change this to 1)
                $optname = SO_BROADCAST; // to enable permission to transmit broadcast datagrams on the socket (you may have to change this to 6)
                $optval = true;
                $opt_returnvalue = socket_set_option($socket, $level, $optname, $optval);
                if ($opt_returnvalue < 0) {
                    $error = "Using 'socket_set_option()' failed, due to error: '" . socket_strerror($opt_returnvalue) . "'<br>\n";
                    return $error; // false
                }
                $flags = 0;
                // To do: handle error 'Operation not permitted'
                $socket_data = socket_sendto($socket, $buf, strlen($buf), $flags, $this->addr, $this->port);
                if ($socket_data) {
                    $function = "socket_sendto";
                    $socket_create = "A magic packet of " . $socket_data . " bytes has been sent via UDP to IP address: " . $this->addr . ":" . $this->port . ", using the '" . $function . "()' function.<br>";
                    $content = bin2hex($buf);
                    $socket_create = $socket_create . "Contents of magic packet:<br><textarea rows=\"1\" name=\"content\" cols=\"" . strlen($content) . "\">" . $content . "</textarea><br>\n";
                    socket_close($socket);
                    unset($socket);
                    return $socket_create; // true
                } else {
                    $error = "Using 'socket_sendto()' failed, due to error: '" . socket_strerror(socket_last_error($socket)) . "' (" . socket_last_error($socket) . ")<br>\n";
                    socket_close($socket);
                    unset($socket);
                    return $error; // false
                }
            } else {
                $error = "Using 'socket_create()' failed, due to error: '" . socket_strerror(socket_last_error($socket)) . "' (" . socket_last_error($socket) . ")<br>\n";
                return $error; // false
            }
        } else {
            $error = "No magic packet has been sent, since no functions are available to transmit it.<br>\n";
            return $error; // false
        }


//        $output=shell_exec('ping -n 2 '.$this->addr);
//        if(strpos($output, "recibidos = 2") && !strpos($output, "inaccesible")){
//            echo "encendido";
//        }else if(strpos($output, "inaccesible")){
//            echo "inaccesible";
//        }else{
//            echo $output;
//        }
    }

    function customError($error_level, $error_message, $error_file, $error_line, $error_context) {
        global $handler_error;
        if (substr_count($error_message, "fsockopen() [") && substr_count($error_message, "]: unable to connect to udp://") && substr_count($error_message, " (Permission denied)")) {
            // Since this error is already caught, it can be surpressed.
        } else {
            if (substr_count($error_message, "It is not safe to rely on the system's timezone settings. ")) {
                $_SESSION['local_timezone_set'] = "Since no timezone was specified, the timezone of the webserver will be used.<br>\n";
            } else {
                $_SESSION['handler_error'] = $_SESSION['handler_error'] . "<br>error_level: " . $error_level . "<br>error_message: <b>" . $error_message . "</b><br>error_file: " . $error_file . "<br>error_line: " . $error_line . "<br>error_context: " . $error_context . "<br>\n";
            }
        }
        return;
    }

    function Encryption($decrypted_data) {
        if (!extension_loaded('mcrypt')) {
            $encrypted_data = $decrypted_data;
        } else {
            //opens the cipher module
            $TD = mcrypt_module_open('tripledes', '', 'ecb', '');
            //create the IV and determine the keysize length, used MCRYPT_RAND on Windows instead 
            $IV = mcrypt_create_iv(mcrypt_enc_get_iv_size($TD), MCRYPT_RAND);
            //initialize encryption-buffers
            //require("Includes/config.php");
            $key = "Masterkey";
            $key = substr($key, 0, mcrypt_enc_get_key_size($TD));
            $s = mcrypt_generic_init($TD, $key, $IV);
            if (($s < 0) || ($s === false)) {
                die("Foutmelding: niet in staat om de encryptiebuffers te initializeren!");
            }
            mcrypt_generic_init($TD, $key, $IV);
            //encrypt data
            $encrypted_data = mcrypt_generic($TD, $decrypted_data);
            //terminate handler and close module
            mcrypt_generic_deinit($TD);
            mcrypt_module_close($TD);
            unset($key);
        }
        return $encrypted_data;
    }

}
