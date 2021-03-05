<?php

declare(strict_types = 1);

namespace TaskForce\utils;

class CsvToSqlConverter
{
	private $csvName;
	private $sqlName;

	private $csvFileObject;
	private $sqlFileObject;


	public function __construct(string $csvName, string $sqlName)
    {
		$this->csvName = '/data/' . $csvName;
        $this->sqlName = '/data/' . $sqlName . '_' . strftime('%Y%m%d_%H-%M-%S') . '.sql';
    }
    public function convert()
    {
    	if (!file_exists($this->csvName)) {
            throw new SourceFileException("CSV файл не существует");
        }

		try {
            $this->csvFileObject = new SplFileObject($this->csvName);
        }
        catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось открыть CSV файл на чтение");
        }

		try {
            $this->sqlFileObject = new SplFileObject($this->sqlName, 'w');
        }
        catch (RuntimeException $exception) {
            throw new SourceFileException("Не удалось создать SQL файл для записи");
        }

        foreach ($this->getNextLine() as $line) {
            $this->result[] = $line;
        }
    }




    private function getNextLine()


   	private function writeLine()



}