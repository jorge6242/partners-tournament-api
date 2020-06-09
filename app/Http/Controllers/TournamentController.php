<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TournamentService;
use Barryvdh\DomPDF\Facade as PDF;

class TournamentController extends Controller
{
    public function __construct(TournamentService $service)
	{
		$this->service = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = $this->service->index($request->query('perPage'));
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList(Request $request)
    {
        $data = $this->service->getList();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataRequest = $request->all();
        $data = $this->service->create($dataRequest);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeParticipant(Request $request)
    {
        $dataRequest = $request->all();
        $data = $this->service->storeParticipant($dataRequest);
        return $data;
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->service->read($id);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataRequest = $request->all();
        $data = $this->service->update($dataRequest, $id);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->service->delete($id);
    }

    /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {
        $data = $this->service->search($request);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

        /**
     * Get the specified resource by search.
     *
     * @param  string $term
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function searchInscriptions(Request $request) {
        $data = $this->service->searchInscriptions($request);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getByCategory(Request $request)
    {
        $data = $this->service->getByCategory($request['id']);
        return $data;
    }

            /**
     * get available tournaments by category
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailableTournamentsByCategory(Request $request)
    {
        $data = $this->service->getAvailableTournamentsByCategory($request['id']);
        return $data;
    }


    /**
     * get available tournament
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailableTournament(Request $request)
    {
        $data = $this->service->getAvailableTournament($request['id']);
            return response()->json([
                'success' => true,
                'data' => $data ? true : false,
            ]);
    }

        /**
     * get available tournament
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailableQuota(Request $request)
    {
        $data = $this->service->getAvailableQuota($request['id']);
            return response()->json([
                'success' => true,
                'data' => $data ? true : false,
            ]);
    }

        /**
     * get available tournament
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAvailablePlayerTournament(Request $request)
    {
        $data = $this->service->getAvailablePlayerTournament($request['id']);
            return response()->json([
                'success' => true,
                'data' => $data,
            ]);
    }

            /**
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInscriptions(Request $request)
    {
        $data = $this->service->getInscriptions($request);
        return $data;
    }

    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInscriptionsByParticipant(Request $request)
    {
        $data = $this->service->getInscriptionsByParticipant($request);
        return $data;
    }


            /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInscriptionsReport(Request $request)
    {
        $data = $this->service->getInscriptionsReport($request);      
        return response()->json([
            'success' => true,
            'data' => $data->list,
            'total' => $data->total,
        ]);
    }

                /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getInscriptionsReportPDF(Request $request)
    {
        $data = $this->service->getInscriptionsReport($request, true);
        $data = [
            'tournament' => $data->tournament,
            'groups' => $data->groups
        ];
        
        $pdf = PDF::loadView('reports/participantsReport', $data);
        return $pdf->download('participantsReport.pdf');
        
    }

            /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getParticipant(Request $request)
    {
        $dataRequest = $request->all();
        $data = $this->service->getParticipant($request['id']);
        return $data;
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateParticipant(Request $request)
    {
        $dataRequest = $request->all();
        $data = $this->service->updateParticipant($dataRequest);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateParticipantPayment(Request $request)
    {
        $dataRequest = $request->all();
        $data = $this->service->updateParticipantPayment($dataRequest);
        if($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
    }

}
