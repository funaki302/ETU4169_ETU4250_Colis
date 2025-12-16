<?php

namespace app\controllers;
use app\models\ProductModel;
use Flight;
use flight\Engine;

class ProductController {
    protected Engine $app;
    protected ProductModel $model;

    public function __construct($app) {
        $this->app = $app;
        $this->model = new ProductModel(Flight::db());
    }

    public function getProduit($id) { 
        return $this->model->getProduit($id); 
    }

    public function home() {
        $products = $this->model->getProduits();
        Flight::render('home', ['products' => $products , 'csp_nonce' => Flight::get('csp_nonce')]);
    }

    public function product($id) {
        $product = $this->model->getProduit($id);
        if ($product === null) {
            $this->app->json(['error' => 'Produit introuvable'], 404);
            return;
        }
        Flight::render('product', ['product' => $product , 'csp_nonce' => Flight::get('csp_nonce')]);
    }

    public function insert() {
        $request = Flight::request();
        $data = $request->data->getData();
        $defaultImage = '1.jpg';

        $data['p_image'] = $this->upload($_FILES['p_image'] , $defaultImage);

        $this->model->insertProduit($data);
        Flight::redirect('/');
    }

    public function update() {
        $request = Flight::request();
        $data = $request->data->getData();

        if (!isset($data['id'])) {
            Flight::json(['error' => 'ID manquant'], 400);
            return;
        }

        $product = $this->model->getProduit($data['id']);
        if (!$product) {
            Flight::json(['error' => 'Produit introuvable'], 404);
            return;
        }

        $data['p_image'] = $this->upload($_FILES['p_image'] , $product['p_image']);

        $this->model->updateProduit($data);
        Flight::redirect('/');
    }

    public function delete($id) {
        $this->model->deleteProduit($id);
        Flight::redirect('/');
    }

    private function upload($file, $currentImage)
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return $currentImage;
        }

        $uploadDir = __DIR__ . '/../../public/images/';
        $tmpName = $file['tmp_name'];
        $fileName = basename($file['name']);
        $uniqueName = time() . '_' . $fileName;
        $targetPath = $uploadDir . $uniqueName;

        if (move_uploaded_file($tmpName, $targetPath)) {
            return $uniqueName;
        }

        return $currentImage;
    }

    public function getTrajetsByDate(){
        return $this->model->getTrajetsByDate(); 
    }
}
