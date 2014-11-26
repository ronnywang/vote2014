<?php

class ApiController extends Pix_Controller
{
    public function init()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET');
    }

    public function countyAction()
    {
        header('Cache-Control: max-age=86400');
        return $this->json(Vote::getCounties());
    }

    public function townAction()
    {
        header('Cache-Control: max-age=86400');
        return $this->json(Vote::getTowns());
    }

    public function partyAction()
    {
        header('Cache-Control: max-age=86400');
        return $this->json(Vote::getParties());
    }

    public function dataAction()
    {
        header('Cache-Control: max-age=60');
        list(, /*api*/, /*data*/, $id) = explode('/', $this->getURI());
        return $this->json(json_decode(VoteData::find($id)->data));
    }

    public function candidateAction()
    {
        header('Cache-Control: max-age=86400');
        list(, /*api*/, /*candidate*/, $id) = explode('/', $this->getURI());
        return $this->json(Candidate::findCandidateByVoteId($id));
    }

}
