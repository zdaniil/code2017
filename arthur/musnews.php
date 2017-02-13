<?php if ( ! defined('SESS_LIFETIME')) exit('No direct script access allowed.');

/**
 * Class musnews
 */
class musnews extends controller{
    function __construct(router $routerInstance){
        parent::__construct($routerInstance);
        if ($_SESSION['user_logged_in'] == false){
            header("Location: ".$this->makeLink('login'));
            exit;
        }
        $this->loadLibrary('simple_html_dom');
        $this->loadLibrary('mycurl');
    }

    public function parseLoudwire(){
        $response = $this->mycurl->curlBegin('http://loudwire.com/');
        $html = str_get_html($response);
        $i = 0;
        if(count($html->find('section.blogroll article'))) {
            foreach ($html->find('section.blogroll article') as $post) {
                $data[$i]['head_link'] = $post->find('header.excerpt h2.title',0)->innertext;
                $data[$i]['author'] = $post->find('span.the_author',0)->innertext;
                $data[$i]['date'] = $post->find('span.the_date',0)->innertext;
                $data[$i]['description'] = $post->find('div.the_excerpt',0)->first_child()->innertext;
                $data[$i]['img_link'] = $post->find('img.wp-post-image',0)->datasrc;
                $i++;
            }
        }


        var_dump($data);
        $html->clear();
        unset($html);
    }
}
