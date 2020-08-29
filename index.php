<?php


$file_links = 'list.txt';
$file_links_block = 'block.txt';
class acl
{
   public $file_links;
   public $file_links_block;

   public function __construct($file_links, $file_links_block)
   {
       $this->file_links = $file_links;
       $this->file_links_block = $file_links_block;
   }

   public function read_write_File($file_links,$file_links_block)
   {
       $lines = explode( PHP_EOL, file_get_contents($file_links));
       foreach($lines as $line ) 
       {
           $full_line = "#" . $line . PHP_EOL.
           "local-zone: " . '"'.$line. ".".'"'." static" . PHP_EOL .
           "local-data: " . '"'.$line. "."." IN A 45.10.35.6" . PHP_EOL. PHP_EOL;
           file_put_contents(__DIR__ . '/'.$file_links_block, $full_line, FILE_APPEND);
       }
   }
}
$acl = new acl($file_links, $file_links_block);
$acl->read_write_File($file_links, $file_links_block );

