<?php

namespace SS6\ShopBundle\Component\UploadedFile;

use SS6\ShopBundle\Component\FileUpload\FileUpload;
use SS6\ShopBundle\Component\UploadedFile\Config\UploadedFileEntityConfig;
use SS6\ShopBundle\Component\UploadedFile\File;

class FileService {

	/**
	 * @var \SS6\ShopBundle\Component\FileUpload\FileUpload
	 */
	private $fileUpload;

	public function __construct(FileUpload $fileUpload) {
		$this->fileUpload = $fileUpload;
	}

	/**
	 * @param \SS6\ShopBundle\Component\UploadedFile\Config\UploadedFileEntityConfig $uploadedFileEntityConfig
	 * @param int $entityId
	 * @param string $temporaryFilename
	 * @param string|null $type
	 * @return \SS6\ShopBundle\Component\UploadedFile\File
	 */
	public function createFile(
		UploadedFileEntityConfig $uploadedFileEntityConfig,
		$entityId,
		$temporaryFilename
	) {
		$temporaryFilepath = $this->fileUpload->getTemporaryFilePath($temporaryFilename);

		return new File(
			$uploadedFileEntityConfig->getEntityName(),
			$entityId,
			pathinfo($temporaryFilepath, PATHINFO_BASENAME)
		);
	}

}
