<?php

declare(strict_types = 1);

namespace TaskForce\utils;

use \SplFileObject;

class CsvToSqlConverter
{
	private string $csvName;
	private string $sqlName;

	private SplFileObject $csvFileObject;
	private SplFileObject $sqlFileObject;
    private string $dataBaseTable;

	public function __construct(string $csvName)
    {
        $this->dataBaseTable = explode('.', $csvName)[0] ?? null; //это же не является нарушением Б37?
        $this->sqlName = 'data/' . $this->dataBaseTable . '.sql';
		$this->csvName = 'data/' . $csvName;
    }

    public function convert(): void
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

        $this->csvFileObject->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE); 

        $headers = $this->getHeaders();
        $firstValues = $this->csvFileObject->fgetcsv();
        $firstValues = $this->arrayToString($firstValues);
        $firstSqlLine = "INSERT INTO $this->dataBaseTable (" . $headers . ")\r\n" . 'VALUES ("' . $firstValues . '"),';
        $this->writeLine($firstSqlLine);

        foreach ($this->getNextLine() as $insertingValues) {
            $insertingValues = $this->arrayToString($insertingValues);
            $line = '       ("' . $insertingValues . '"),';
            $line = str_replace('"NULL"','NULL',$line);
            $this->writeLine($line);
        }
    }
    
    private function getHeaders(): string {
        $this->csvFileObject->rewind();
        $data = $this->csvFileObject->fgetcsv();
        $headers = array_shift($data);
        foreach ($data as $value) {
            $headers .= ", $value";
        }
        return $headers;
    }
    private function getNextLine(): iterable {
        while (!$this->csvFileObject->eof()) {
            yield $this->csvFileObject->fgetcsv();
        }
    }
   	private function writeLine(string $line): void
    {
        $this->sqlFileObject->fwrite("$line\r\n");
    }
    private function arrayToString(array $array): string
    {
        return implode('", "', $array);
    }
}