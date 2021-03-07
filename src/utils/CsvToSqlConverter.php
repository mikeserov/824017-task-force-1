<?php

declare(strict_types = 1);

namespace TaskForce\utils;

use \SplFileObject;

class CsvToSqlConverter
{
	private $csvName;
	private $sqlName;

	private $csvFileObject;
	private $sqlFileObject;
    private $dataBaseTable;


	public function __construct(string $csvName, string $dataBaseTable)
    {
		$this->csvName = 'data/' . $csvName;
        $this->sqlName = 'data/' . $dataBaseTable . strftime('%Y-%m-%d_%H-%M-%S') . '.sql';
        $this->dataBaseTable = $dataBaseTable;
    }
    public function convert()
    {
    	if (!file_exists($this->csvName)) {
            throw new SourceFileException("CSV файл не существует");
        }
        //var_dump($this->csvName);
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

        $this->csvFileObject->setFlags(SplFileObject::READ_CSV); 


        $headers = $this->getHeaders();
        $this->csvFileObject->seek(1);
        $firstValues = implode('", "', $this->csvFileObject->fgetcsv());
        
        $firstSqlLine = "INSERT INTO $this->dataBaseTable (" . $headers . ') VALUES ("' . $firstValues . '"),';
        $this->writeLine($firstSqlLine);

        $this->csvFileObject->seek(2);
        foreach ($this->getNextLine() as $insertingValues) {

            $line = '("' . implode('", "', $insertingValues) . '"),';
            $this->writeLine($line);
        }

        echo 'УСПЕШНО';
    }

    private function getNextLine(): ?iterable {
        while (!$this->csvFileObject->eof()) {
            yield $this->csvFileObject->fgetcsv();
        }
    }

   	private function writeLine($line)
    {
        $this->sqlFileObject->fwrite($line . "/r/n");
    }
    private function getHeaders(): string {
        $this->csvFileObject->rewind();
        $data = $this->csvFileObject->fgetcsv();
        $headers = (string) $data[0]; //не пойму, стоит ли здесь явно приводить к string, захотелось перестраховаться, т.к. вдруг каким-то образом 1-е полe окажется int
        foreach ($data as $value) {
            $headers .= ", $value";
        }
        return $headers;
    }


}