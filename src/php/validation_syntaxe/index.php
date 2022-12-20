<?php
error_reporting(E_ALL|E_STRICT);

use Parle\Token;
use Parle\Lexer;
use Parle\LexerException;

include("includes/correction.php");

class MyParser {

        private $inputStream;
        private string $inputEncoding = "UTF-8";
        
        private array $patterns = [
            'comments'  => ["/^\#+/", "/(\/\/)+/", "/(?:#|\/\/)(^\r\n)*|\/\*.*?\*\//im"],
            'text'      => ["/^(\w+)/"],
            'integers'  => ["/^(\d+)/"],
            'operators' => ["/(\{+\W+\}*)/"]
        ];

        public function parseString(string $filename, string $mode = 'r') {
            // Parse the string here 
            // ob_start(); # enable output buffering
            $this->inputString = fopen($filename, $mode);
            // sniff the input file encoding 
            // $this->inputEncoding = mb_detect_encoding(
            //        fread(
            //            $this->inputString, \
            //            filesize($filename) 
            //            )
            //       );
            
            while(1){
                $line = fgets($this->inputString);
                foreach ($this->patterns as $pattern) {
                    #var_dump($pattern);
                    foreach ($pattern as $p) {
                    #    #var_dump($p);
                        if (preg_match_all($p, $line)) {
                            echo "Valid syntax!";
                            var_dump($p);
                            return true;
                        }
                    }
                    
                }
                break ;
            } 
            echo ("Syntax is invalid!");
            return false ;
        }

} 

$p = new MyParser ();
$p->parseString("codes/05.txt");

?>
