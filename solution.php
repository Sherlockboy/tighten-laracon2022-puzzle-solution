<?php

class Problem
{
    private array $patterns;
    private string $encodedImage;

    public function __construct()
    {
        $this->patterns = ['(', ')', '~', '#', '%', '*', '!', '^', '@'];
        $this->encodedImage = $this->loadData();
    }

    public function solve()
    {
        return $this->writeToFile()
            ? "Success!"
            : "Error!";
    }

    private function writeToFile()
    {
        /**
         * $data[0] is base64 encoded file format
         * $data[1] is actual base64 encoded file
         */
        $data = explode(',', $this->decodeImage());

        return file_put_contents(
            $this->generateFileName('result', $data[0]),
            base64_decode($data[1])
        );
    }

    private function generateFileName(string $name, string $format)
    {
        return $name . '.' . $this->getExtension($format);
    }

    private function getExtension($format)
    {
        $start = strpos($format, '/') + 1;
        $length = strpos($format, ';') - $start;
        
        return substr($format, $start, $length);
    }

    private function decodeImage()
    {
        return str_replace($this->patterns, '', $this->encodedImage);
    }

    private function loadData()
    {
        return file_get_contents('data.txt');
    }
}

echo (new Problem())->solve();
