<?php

class LogTransactions
{
    /**
     * @param $message
     * @param $type
     * @param $location
     */
    public function log_message($message, $type, $location)
    {
        $filename = date("Y-m-d");
        $this->hendler($location, $filename);
        $content = $this->log($message, $type);
        $filename = fopen($filename,'a');
        fwrite($filename, $content);
        fclose($filename);
    }

    /**
     * @param $message
     * @param $type
     * @return string
     */
    private function log($message, $type)
    {
        $date = date('Y-m-d H:i:s');
        switch ($type) {
            case 1:
                return "Status: ERROR | {$date} | {$message}";
            case 2:
                return "Status: INFO | {$date} | {$message}";
            case 3:
                return "Status: DEBUG | {$date} | {$message}";
        }
    }

    /**
     * @param $location
     * @param $filename
     */
    private function hendler($location, $filename)
    {
        if (!file_exists($location . $filename . '.log')) {
            fopen($filename.'.log','w');
        }
    }
}