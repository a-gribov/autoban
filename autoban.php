<?php

$file_links = 'list.txt';
$file_links_block = 'blk-zones.conf';
class acl
{
	 public $file_links;
	 public $file_links_block;

	 public function __construct($file_links, $file_links_block)
	 {
			 $this->file_links = $file_links;
			 $this->file_links_block = $file_links_block;
	 }

	 public function deleteFile($file_links_block)
	 {
		if (file_exists($file_links_block)) 
			{
				unlink($file_links_block);
			}
	 }
	 public function writeHeader($file_links_block)
	 {
		file_put_contents(__DIR__ . '/'.$file_links_block, "server" . PHP_EOL . PHP_EOL .
					 "unblock-lan-zones: yes" . PHP_EOL .
					 "insecure-lan-zones: yes". PHP_EOL. PHP_EOL);
	 }
	 public function read_write_File($file_links,$file_links_block)
	 {
			$lines = array_unique( explode( PHP_EOL, file_get_contents($file_links))); // чтение файла со списоком сайтов.
		
			 foreach($lines as $line ) 
			 {
			$line = idn_to_ascii($line,IDNA_NONTRANSITIONAL_TO_ASCII,INTL_IDNA_VARIANT_UTS46);	// проверка и конвертирование кодировок

					 $full_line = "#" . $line . PHP_EOL.
					 "local-zone: " . '"'.$line. ".".'"'." static" . PHP_EOL .
					 "local-data: " . '"'.$line. "."." IN A 45.10.35.6" . PHP_EOL. PHP_EOL;
					 file_put_contents(__DIR__ . '/'.$file_links_block, $full_line, FILE_APPEND);
			 }
	 }
}
$acl = new acl($file_links, $file_links_block);
$acl->deleteFile($file_links_block);
$acl->writeHeader($file_links_block);
$acl->read_write_File($file_links, $file_links_block );



