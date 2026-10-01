<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CsvManager
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        #[Autowire('%kernel.project_dir%')] private readonly string $projectDir,
    ) {
    }
    public function readCsv(string $path, $delimiter = ','): ?array
    {
        $filePath = $this->projectDir . $path;

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Файл не знайдено');
        }

        $fileContext = file_get_contents($filePath);

        return $this->serializer->decode($fileContext, 'csv', [
            CsvEncoder::DELIMITER_KEY => $delimiter
        ]);
    }
}
