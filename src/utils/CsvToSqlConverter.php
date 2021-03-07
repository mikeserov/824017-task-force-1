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

        $firstLinePart = "INSERT INTO $this->dataBaseTable (" . getHeaders();
        $this->csvfileObject->seek(1);
        foreach ($this->getNextLine() as $insertingValues) {
            $line = $firstLinePart .  . ") VALUES ();"
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

        str_replace

        $headers = (string) $data[0]; //не пойму стоит ли здесь явно приводить к string, захотелось т.к. вдруг каким-то образов полу будет
        if (count($data) > 1) {
            foreach ($data as $value) {
                $headers .= ", $value"
            }
        }
        return $headers;
    }

}