<?php

declare(strict_types = 1);

namespace TaskForce\utils;

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
        $this->sqlName = 'data/' . $dataBaseTable . strftime('%Y-%m-%d_%H-%M-%S') .;
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

        $this->csvfileObject->setFlags(SplFileObject::READ_CSV); 


        $headers = getHeaders();
        $this->csvfileObject->seek(1);
        $firstValues = implode($this->csvfileObject->fgetcsv(), '", "');
        
        $firstSqlLine = "INSERT INTO $this->dataBaseTable (" . $headers . ') VALUES ("' . $firstValues . '"),';
        writeLine($firstSqlLine);

        $this->csvfileObject->seek(2);
        foreach ($this->getNextLine() as $insertingValues) {

            $line = '("' . implode($insertingValues, '", "') . '"),';
            
            writeLine($line);
        }
    }

    private function getNextLine(): ?iterable {
        while (!$this->csvfileObject->eof()) {
            yield $this->csvfileObject->fgetcsv();
        }
    }

   	private function writeLine($line)
    {
        $this->sqlFileObject->fwrite($line . "/r/n");
    }
    private function getHeaders(): string {
        $this->csvFileObject->rewind();
        $data = $this->csvfileObject->fgetcsv();
        $headers = (string) $data[0]; //не пойму, стоит ли здесь явно приводить к string, захотелось перестраховаться, т.к. вдруг каким-то образом 1-е полe окажется int
        foreach ($data as $value) {
            $headers .= ", $value"
        }
        return $headers;
    }


}