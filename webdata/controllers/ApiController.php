<?php

class ApiController extends Pix_Controller
{
    public function countyAction()
    {
        return $this->json(Vote::getCounties());
    }

    public function townAction()
    {
        return $this->json(Vote::getTowns());
    }

    public function dataAction()
    {
        list(, /*api*/, /*data*/, $id) = explode('/', $this->getURI());
        return $this->json(json_decode(VoteData::find($id)->data));
    }

}