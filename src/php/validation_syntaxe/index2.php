<?php
error_reporting(E_ALL|E_STRICT);


use Parle\{Parser, ParserException, Lexer, Token};

include("includes/correction.php");




class MyParser {

        private $inputStream;
        private string $inputEncoding = "UTF-8";
        
     
        private $re_comments = ["[^\#+]", "[(\/\/)+]", "[(?:#|\/\/)(^\r\n)*|\/\*.*?\*\/]im"];
        private $re_text = ["[^(\w+)/]",];
        private $re_integer = ["[/^(\d+)/]",];
        private $re_operators = ["[(\{+\W+\}*)]",];

        

        public function pushArray($array, $lex) {
            $idx = 0;
            foreach($array as $item) {
                $idx += 1;
                $lex->push($item, $idx);
            }
            $lex->build();
        }
        
        public function parseFile(string $filename, string $mode = 'r') {
            // Parse the string here 
            // ob_start(); # enable output buffering
            $this->inputString = fopen($filename, $mode);
            
           
            $p = new Parser;
            $lex = new Lexer;
            $idx = 0;

            foreach([$this->re_comments, 
                     $this->re_text, 
                     $this->re_integer, 
                     $this->re_operators] as $v) {
                #var_dump($v);
                $idx += 1;
                foreach($v as $item){
                    $lex->push($item, $idx); // prepare the lexer
                }
            }

            //$p->build();      // finalize lexer config
            $isvalid = false;   // by default return false
            
            $line = fgets($this->inputString);
            var_dump($line);
            $lex->consume($line);
            $lex->build();
            
            // line validation! 
            // if (! $p->validate($line, $lex)) {
            //    throw new ParserException("Failed to validate input!");
            //} else {
            //    $isvalid = true;
            //}

            do {
                $lex->advance();
                $tok = $lex->getToken();
                var_dump($tok);
                #if (!$p->validate($line, $lex)) {
                #    throw new ParserException("Failed to validate input");
                #} 
                if (Token::UNKNOWN == $tok->id) {
                    throw new LexerException("Unknown token '{$tok->value}' at offset {$lex->marker}.");
                } else {
                    $isvalid = true;
                }
            } while (Token::EOI != $tok->id); 
        
            if ($isvalid) {
                echo "Syntax is OK";
            } else {
                echo "Error !!";
            }
            return $isvalid ;
        } 
}

# Tests...
$p = new MyParser;
$p->parseFile("codes/03.txt");

