<?php

class WebClient
{
    private $ch;
    private $cookie = 'TESTID=set;';
    private $html;

    public function Navigate($url, $post = array())
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_COOKIE, $this->cookie);
        if (!empty($post)) {
            curl_setopt($this->ch, CURLOPT_POST, TRUE);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post);
        } else {
            curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        }
        $response = $this->exec();
        if ($response['Code'] !== 200) {
            return $response;
        }
        return $response['Html'];
    }

    public function getInputs()
    {
        $return = array();

        $dom = new DOMDocument();
        @$dom->loadHtml($this->html);
        $inputs = $dom->getElementsByTagName('input');
        foreach($inputs as $input)
        {
            if ($input->hasAttributes() && $input->attributes->getNamedItem('name') !== NULL)
            {
                if ($input->attributes->getNamedItem('value') !== NULL)
                    $return[$input->attributes->getNamedItem('name')->value] = $input->attributes->getNamedItem('value')->value;
                else
                    $return[$input->attributes->getNamedItem('name')->value] = NULL;
            }
        }

        return $return;
    }

    public function __construct()
    {
        $this->init();
    }

    public function __destruct()
    {
        $this->close();
    }

    private function init()
    {
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36");
        curl_setopt($this->ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_HEADER, true);
        curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);

    }

    private function exec()
    {
        $headers = array();
        $html = '';

        ob_start();
        curl_exec($this->ch);
        $output = ob_get_contents();
        ob_end_clean();

        $retcode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

        if ($retcode == 200) {
            $separator = curl_getinfo($this->ch, CURLINFO_HEADER_SIZE);

            $html = substr($output, $separator);

            $h = trim(substr($output,0,$separator));
            $lines = explode("\n", $h);
            foreach($lines as $line) {
                $kv = explode(':',$line,2);

                if (count($kv) == 2) {
                    $k = trim($kv[0]);
                    $v = trim($kv[1]);
                    $headers[$k] = $v;
                }
            }
        }

        if (!empty($headers['Set-Cookie']))
            $this->cookie = "TESTID=set; " . $headers['Set-Cookie'];

        $this->html = $html;

        return array('Code' => $retcode, 'Headers' => $headers, 'Html' => $html);
    }

    private function close()
    {
        curl_close($this->ch);
    }
}

?>