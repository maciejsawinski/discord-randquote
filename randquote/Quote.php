<?php 

class Quote {

    public function getCommands() { 

        return '```http
Lista komend:

;;quote - generuje losowy cytat

;;info - informacje o projekcie
```';
    }
    
    public function getInfo() { 

        return '```http
Random Quote Bot for Discord

GitHub - https://github.com/maciejsawinski/discord-randquote
Copyright (c) 2017 Maciej Sawiński
```';
    }
    
    public function getRandomQuote() { 
        
        $pageContent = $this->getHtmlContent('http://ecytaty.pl/losuj-cytat.html');
        
        return '```http
' . $this->getRandomPhrase() . ':
    
' . $this->getQuote($pageContent) . '
    ~' . $this->getAuthor($pageContent) . '```';
    }
    
    private function getHtmlContent($url) {
        
        $pageContent=file_get_contents($url);
        if (!$pageContent) {
            
            $this->getHtmlContent($url);
        }
        
        return $pageContent;
    }
    
    private function getRandomPhrase() {
        
        $phrases = ['Cytat na dziś','Myśl na dziś','Daje do myślenia','Przemyśl to','Co o tym sądzisz','Hmm','Ciekawostki ze świata','Czy zgadzasz się z tym','Skłania do dyskusji','Tylko nie Paulo Coelho'];
        
        return $phrases[array_rand($phrases)];
    }
    private function getQuote($pageContent) {
        
        preg_match_all("/\<p class\=\"tresc\"\>(.*?)\<\/p\>/",$pageContent,$rawQuote);     
        $quote = explode('>', $rawQuote[1][0]); 
        $quote = explode('<', $quote[1]);
        
        return $quote[0];
    }
    
    private function getAuthor($pageContent) {
        
        preg_match_all("/\<p class\=\"autor\"\>(.*?)\<\/p\>/",$pageContent,$rawAuthor);
        $author = explode('>', $rawAuthor[1][0]); 
        $author = explode('<', $author[1]);

        return $author[0];
    }
}