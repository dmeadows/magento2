<?php

// ...

use Magento\Framework\Filesystem\Io\File as IoFile;

// ...

class Image extends AbstractValidator
{
    // ...

    /**
     * @var IoFile
     */
    private $ioFile;

    /**
     * @param Mime $fileMime
     * @param Factory $imageFactory
     * @param File $file
     * @param IoFile $ioFile
     */
    public function __construct(
        Mime $fileMime,
        Factory $imageFactory,
        File $file,
        IoFile $ioFile
    ) {
        $this->fileMime = $fileMime;
        $this->imageFactory = $imageFactory;
        $this->file = $file;
        $this->ioFile = $ioFile;

        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    public function isValid($filePath): bool
    {
        $fileMimeType = $this->fileMime->getMimeType($filePath);
        $isValid = true;

        if (stripos(json_encode($this->imageMimeTypes), json_encode($fileMimeType)) !== false) {
            try {
                $image = $this->imageFactory->create($filePath);
                $image->open();
            } catch (\Exception $e) {
                $isValid = false;
            }
        } else {
            $isValid = false;
        }
        
        if ($isValid) {
            $fileSize = $this->ioFile->getSize($filePath);
            if ($fileSize <= 0) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}
