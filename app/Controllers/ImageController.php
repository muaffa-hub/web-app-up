<?php

namespace App\Controllers;

use App\Models\ProductImageModel;

class ImageController extends BaseController
{
    public function product(int $productId, int $index = 0)
    {
        $images = (new ProductImageModel())->getByProduct($productId);

        if (empty($images) || !isset($images[$index])) {
            return $this->response->setStatusCode(404);
        }

        return $this->serveFile(WRITEPATH . 'uploads/products/' . basename($images[$index]['file_path']));
    }

    public function productById(int $imageId)
    {
        $image = (new ProductImageModel())->find($imageId);
        if (!$image) return $this->response->setStatusCode(404);

        return $this->serveFile(WRITEPATH . 'uploads/products/' . basename($image['file_path']));
    }

    public function content(string $filename)
    {
        return $this->serveFile(WRITEPATH . 'uploads/content/' . basename($filename));
    }

    public function design(string $filename)
    {
        return $this->serveFile(WRITEPATH . 'uploads/designs/' . basename($filename));
    }

    private function serveFile(string $path)
    {
        if (!file_exists($path)) {
            return $this->response->setStatusCode(404);
        }

        $mime = mime_content_type($path);
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($path));
    }
}
