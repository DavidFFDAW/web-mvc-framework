<?php

class LandingController extends Controller implements SimpleController
{
    public function index()
    {
        $metas = new Metas();
        // $users = Db::getInstance()->query('SELECT * FROM users');

        // return $this->view('landing', [
        //     'title' => 'Landing Page',
        //     'description' => 'This is the landing page description',
        //     'users' => $users,
        //     'metas' => $metas->get(),
        // ]);

        return $this->json([
            'title' => 'Landing Page',
            'description' => 'This is the landing page description',
            'metas' => $metas->get(),
        ], 404);
    }
}
