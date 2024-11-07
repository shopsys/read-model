<?php

declare(strict_types=1);

namespace Shopsys\ReadModelBundle\Twig;

use Shopsys\FrameworkBundle\Component\Image\Exception\ImageNotFoundException;
use Shopsys\FrameworkBundle\Component\Image\ImageUrlWithSizeHelper;
use Shopsys\FrameworkBundle\Twig\ImageExtension as BaseImageExtension;
use Shopsys\ReadModelBundle\Image\ImageView;

class ImageExtension extends BaseImageExtension
{
    /**
     * @param \Shopsys\FrameworkBundle\Component\Image\Image|\Shopsys\ReadModelBundle\Image\ImageView|object|null $imageView
     * @param array $attributes
     * @return string
     */
    public function getImageHtml($imageView, array $attributes = []): string
    {
        if ($imageView === null) {
            return $this->getNoimageHtml($attributes);
        }

        if ($imageView instanceof ImageView) {
            $this->preventDefault($attributes);

            $entityName = $imageView->getEntityName();

            $attributes['src'] = $this->imageFacade->getImageUrlFromAttributes(
                $this->domain->getCurrentDomainConfig(),
                $imageView->getId(),
                $imageView->getExtension(),
                $entityName,
                $imageView->getType(),
            );

            $attributes['alt'] = $imageView->getName();

            return $this->getImageHtmlByEntityName($attributes, $entityName);
        }

        return parent::getImageHtml($imageView, $attributes);
    }

    /**
     * @param \Shopsys\FrameworkBundle\Component\Image\Image|\Shopsys\ReadModelBundle\Image\ImageView|object $imageOrEntity
     * @param array $attributes
     * @return string
     */
    protected function getImageUrl($imageOrEntity, array $attributes): string
    {
        $width = null;
        $height = null;

        if (array_key_exists('width', $attributes)) {
            $width = (int)$attributes['width'];
        }

        if (array_key_exists('height', $attributes)) {
            $height = (int)$attributes['height'];
        }

        try {
            return ImageUrlWithSizeHelper::limitSizeInImageUrl($this->imageFacade->getImageUrl(
                $this->domain->getCurrentDomainConfig(),
                $imageOrEntity,
                $attributes['type'],
            ), $width, $height);
        } catch (ImageNotFoundException $e) {
            return $this->getEmptyImageUrl();
        }
    }
}
