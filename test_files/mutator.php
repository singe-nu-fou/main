<?php
    class mutator{
        private $string;
        
        function __construct(){
            $this->string = '';
        }
        
        function appendSpecial($special){
            $this->string .= $special;
            return $this;
        }
        
        function appendA(){
            $this->string .= 'a';
            return $this;
        }
        
        function appendB(){
            $this->string .= 'b';
            return $this;
        }
        
        function appendC(){
            $this->string .= 'c';
            return $this;
        }
        
        function appendD(){
            $this->string .= 'd';
            return $this;
        }
        
        function appendE(){
            $this->string .= 'e';
            return $this;
        }
        
        function appendF(){
            $this->string .= 'f';
            return $this;
        }
        
        function appendG(){
            $this->string .= 'g';
            return $this;
        }
        
        function appendH(){
            $this->string .= 'h';
            return $this;
        }
        
        function appendI(){
            $this->string .= 'i';
            return $this;
        }
        
        function appendJ(){
            $this->string .= 'j';
            return $this;
        }
        
        function appendK(){
            $this->string .= 'k';
            return $this;
        }
        
        function appendL(){
            $this->string .= 'l';
            return $this;
        }
        
        function appendM(){
            $this->string .= 'm';
            return $this;
        }
        
        function appendN(){
            $this->string .= 'n';
            return $this;
        }
        
        function appendO(){
            $this->string .= 'o';
            return $this;
        }
        
        function appendP(){
            $this->string .= 'p';
            return $this;
        }
        
        function appendQ(){
            $this->string .= 'q';
            return $this;
        }
        
        function appendR(){
            $this->string .= 'r';
            return $this;
        }
        
        function appendS(){
            $this->string .= 's';
            return $this;
        }
        
        function appendT(){
            $this->string .= 't';
            return $this;
        }
        
        function appendU(){
            $this->string .= 'u';
            return $this;
        }
        
        function appendV(){
            $this->string .= 'v';
            return $this;
        }
        
        function appendW(){
            $this->string .= 'w';
            return $this;
        }
        
        function appendX(){
            $this->string .= 'x';
            return $this;
        }
        
        function appendY(){
            $this->string .= 'y';
            return $this;
        }
        
        function appendZ(){
            $this->string .= 'z';
            return $this;
        }
        
        function upperEach(){
            $this->string = ucwords($this->string);
            return $this;
        }
        
        function upperFirst(){
            $this->string = ucfirst($this->string);
            return $this;
        }
        
        function lowerFirst(){
            $this->string= lcfirst($this->string);
            return $this;
        }
        
        function upperAll(){
            $this->string = strtoupper($this->string);
            return $this;
        }
        
        function retrieveString(){
            return $this->string;
        }
    }
    
    $var = new mutator();
    $string = $var->appendH()
                  ->appendE()
                  ->appendL()
                  ->appendL()
                  ->appendL()
                  ->appendO()
                  ->appendSpecial(' ')
                  ->appendW()
                  ->appendO()
                  ->appendR()
                  ->appendL()
                  ->appendD()
                  ->appendSpecial('! ')
                  ->upperEach()
                  ->retrieveString();
    echo $string;
    $var->__construct();
    $string = $var->appendM()
                  ->appendU()
                  ->appendT()
                  ->appendA()
                  ->appendT()
                  ->appendO()
                  ->appendR()
                  ->appendS()
                  ->appendSpecial(' ')
                  ->appendS()
                  ->appendU()
                  ->appendC()
                  ->appendK()
                  ->appendSpecial('... ')
                  ->upperFirst()
                  ->retrieveString();
    echo $string;
    $var->__construct();
    $string = $var->appendA()
                  ->appendSpecial(' ')
                  ->appendL()
                  ->appendO()
                  ->appendT()
                  ->appendSpecial('! ')
                  ->upperAll()
                  ->lowerFirst()
                  ->retrieveString();
    echo $string;
    $chars = array('W','h','a','t',' ','t','h','e',' ','h','e','l','l','... ');
    $var->__construct();
    foreach($chars as $char){
        $var->appendSpecial($char);
    }
    $string = $var->retrieveString();
    echo $string;
    $stringA = 'For what purpose have I done this...';
    $chars = str_split($stringA);
    $var->__construct();
    foreach($chars as $char){
        $var->appendSpecial($char);
    }
    $stringB = $var->retrieveString();
    echo $stringB;