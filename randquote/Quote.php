<?php 

class Quote {

    public function getRandomQuote() { 
        
        $pageContent = $this->getHtmlContent('http://ecytaty.pl/losuj-cytat.html');
        
        return  '`' . $this->getQuote($pageContent). ' ~ ' . $this->getAuthor($pageContent). '`';
    }
    
    private function getHtmlContent($url) {
        
        $pageContent=file_get_contents($url);
        if (!$pageContent) {
            
            $this->getHtmlContent($url);
        }
        
        return $pageContent;
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