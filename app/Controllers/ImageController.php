<?php

namespace App\Controllers;

use App\Models\ProductImageModel;

class ImageController extends BaseController
{
    public function product(int $productId, int $index = 0)
    {
        $images = (new ProductImageModel())->getByProduct($productId);

        if (empty($images) || !isset($images[$index])) {
            return $this->placeholder();
        }

        return $this->serveFile(WRITEPATH . 'uploads/products/' . basename($images[$index]['file_path']));
    }

    public function productById(int $imageId)
    {
        $image = (new ProductImageModel())->find($imageId);
        if (!$image) return $this->placeholder();

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
            return $this->placeholder();
        }

        $mime = mime_content_type($path);
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($path));
    }

    private function placeholder()
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400" viewBox="0 0 400 400">'
             . '<rect width="400" height="400" fill="#f3f4f6"/>'
             . '<g fill="none" stroke="#d1d5db" stroke-width="8" stroke-linecap="round" stroke-linejoin="round">'
             . '<rect x="130" y="140" width="140" height="110" rx="10"/>'
             . '<circle cx="170" cy="180" r="14"/>'
             . '<path d="M150 250l40-40 30 26 28-32 32 46"/></g>'
             . '<text x="200" y="300" font-family="sans-serif" font-size="22" fill="#9ca3af" text-anchor="middle">Gambar tidak tersedia</text>'
             . '</svg>';

        return $this->response
            ->setStatusCode(404)
            ->setHeader('Content-Type', 'image/svg+xml')
            ->setHeader('Cache-Control', 'no-store')
            ->setBody($svg);
    }
}
