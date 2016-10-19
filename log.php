<?php
	require_once 'parsecsv.php';

  class Log {
    private $filename,
            $fh,
            $head;

    function __construct($filename, $head) {
      $this->filename = $filename;
      $this->head = $head;
      $this->open();
    }

    function open() {

      if(!file_exists($this->filename)) {
      	$newfile = fopen($this->filename, 'w') or die ('Unable to open file!');
      	fputcsv($newfile, $this->head);
      	fclose($newfile);
      }
      $this->fh = new parseCSV();
      $this->fh->parse($this->filename);
    }

    function write_csv($note) {
      $line = array();
      foreach ($this->head as $value) {
      	array_push($line, $note[$value]);
      }
      $this->fh->data[] = $line;
      $this->fh->save();
    }
  }
?>