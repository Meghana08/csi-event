<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



// routes for all the admin panel comes here
Route::group(['prefix'=> 'admin' ,'namespace'=>'Admin'], function(){
	// all the routes for front-end site
	Route::get('/sample', ['as' => 'sample', 'uses' => function () {
		return View('backend.sample-list');

	}]);
    Route::get('/', ['as' => 'admin', 'uses' => 'Auth\AdminAuthController@index']);
    
    Route::get('login', [ 'middleware' => 'guest.admin', 'uses' => 'Auth\AdminAuthController@getLogin'] );
	Route::post('login', [ 'as' => 'adminLogin', 'uses' => 'Auth\AdminAuthController@postLogin'] );
	Route::get('logout', [ 'as' => 'logout', 'uses' => 'Auth\AdminAuthController@getLogout']);

	Route::get('dashboard', ['middleware'=>'auth.admin', 'as' => 'adminDashboard', 'uses'=>'AdminDashboardController@index']);	


Route::group(['prefix' => 'payments', 'middleware'=>'auth.admin'], function(){
	Route::get('/{id}', ['as' => 'adminMemberPaymentDetails', 'uses' => 'PaymentController@index']);
	Route::get('/', [ 'as' => 'adminMembershipContent', 'uses'=>'MembershipController@index' ]);
});

//New routes admin side

Route::group(['prefix' => 'events', 'middleware'=>'auth.admin'], function(){
	Route::get('filter',[ 'as' => 'adminFilters', 'uses'=>'EventController@index' ]);//for  Filtering
	Route::get('/show-subscribers/{id}/filter', [ 'as' => 'adminSubscriberFilters', 'uses'=>'EventController@subscribersFilter' ]);
		Route::get('/', [ 'as' => 'adminEventContent', 'uses'=>'EventController@index' ]);
	// Route::post('/',[ 'as' => 'adminEventChange', 'uses'=>'EventController@changeStatus' ]);
	Route::get('/{id}', [ 'as' => 'adminEventDetails', 'uses'=>'EventController@showEvent' ]);
	Route::get('change-status/{id}/accept', [ 'as' => 'changeStatusAccept', 'uses'=>'EventController@changeStatusAccept' ]);
	Route::get('change-status/{id}/reject', [ 'as' => 'changeStatusReject', 'uses'=>'EventController@changeStatusReject' ]);
	Route::get('grantb-status-change/{id}/accepted', [ 'as' => 'grantStatusChangeAccept', 'uses'=>'EventController@grantStatusChangeAccept' ]);
	Route::post('grant-status-change/{id}/reject', [ 'as' => 'grantStatusChangeReject', 'uses'=>'EventController@grantStatusChangeReject' ]);
	Route::post('grant-status-change/{id}/negotiate', [ 'as' => 'grantStatusChangeNegotiate', 'uses'=>'EventController@grantStatusChangeNegotiate' ]);
	Route::get('change-status/{id}', [ 'as' => 'changeStatus', 'uses'=>'EventController@changeStatus' ]);
	Route::get('cancel-event/{id}/accept', [ 'as' => 'cancelEventAccept', 'uses'=>'EventController@cancelEventAccept' ]);
	Route::get('cancel-event/{id}/reject', [ 'as' => 'cancelEventReject', 'uses'=>'EventController@cancelEventReject' ]);
	Route::get('specific/{id}', [ 'as' => 'adminViewSpecificEvents', 'uses'=>'EventController@viewSpecific' ]);
	Route::get('show-subscribers/{id}', [ 'as' => 'adminshowSuscribers', 'uses'=>'EventController@showSuscribers' ]);
	Route::get('/show-nominees/{id}/csi', ['as' => 'adminshowNomineesCSI', 'uses'=>'EventController@showNomineeDetailsCSI']);
	Route::get('/show-nominees/{id}/organisation', ['as' => 'adminshowNomineesORG', 'uses'=>'EventController@showNomineeDetailsORG']);
	
	Route::get('logo/{filename}', ['as' => 'adminEventLogo', 'uses' => function($filename){
	    $path = storage_path() . '/uploads/events/logos/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]);

	Route::get('banners/{filename}', ['as' => 'adminEventBanner', 'uses' => function($filename){
	    $path = storage_path() . '/uploads/events/banners/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]);



	Route::get('pdfs/{filename}', ['as' => 'adminEventPDF', 'uses' => function($filename){
	    $path = storage_path() . '/uploads/events/pdfs/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]);
	
});




	Route::group(['prefix' => 'memberships', 'middleware'=>'auth.admin'], function(){
		Route::get('/', [ 'as' => 'adminMembershipContent', 'uses'=>'MembershipController@index' ]);
		// Route::get('{typeId}/verify/{id}', [ 'as' => 'backendInstitutionVerifyById', 'uses'=>'InstitutionController@verify' ]);
		// Route::get('{typeId}/profile/{id}', [ 'as' => 'backendInstitutionById', 'uses'=>'InstitutionController@profile' ]);
		// Route::get('{typeId}/profile/{id}/reject/{pid}', [ 'as' => 'backendInstitutionRejectById', 'uses'=>'InstitutionController@reject_payment' ]);
		// Route::post('{typeId}/profile/{id}/reject/{pid}', [ 'as' => 'backendInstitutionRejectById', 'uses'=>'InstitutionController@store_reject_payment' ]);
		// Route::get('{typeId}/profile/{id}/accept/{pid}', [ 'as' => 'backendInstitutionAcceptById', 'uses'=>'InstitutionController@accept_payment' ]);
		// Route::get('listStudentBranch', [ 'as' => 'backendInstitutionListStudentBranch', 'uses'=>'InstitutionController@listStudentBranch' ]);
		// Route::get('makeStudentBranch/{rid}', [ 'as' => 'backendInstitutionMakeStudentBranch', 'uses'=>'InstitutionController@makeStudentBranch' ]);
		// Route::get('{typeId}', [ 'as' => 'backendInstitution', 'uses'=>'InstitutionController@index' ]);
		// Route::get('/', [ 'as' => 'backendInstitutionHome', 'uses'=>'AdminDashboardController@index' ]);
	});

	Route::get('proofs/{filename}', function($filename){
	    $path = storage_path() . '/uploads/payment_proofs/' . $filename;

		$filetype = File::mimeType($path);
		$imgbinary = fread(fopen($path, "r"), filesize($path));
    	$file = 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);

	    //$file = base64_encode(file_get_contents($path));

	    return view('backend.individuals.proof', compact('file'));
	});

	Route::group(['prefix' => 'individual', 'middleware'=>'auth.admin'], function(){
		
		Route::get('{typeId}/verify/{id}', [ 'as' => 'backendIndividualVerifyById', 'uses'=>'IndividualController@verify' ]);
		Route::get('{typeId}/profile/{id}', [ 'as' => 'backendIndividualById', 'uses'=>'IndividualController@profile' ]);
		Route::get('{typeId}/profile/{id}/reject/{pid}', [ 'as' => 'backendIndividualRejectById', 'uses'=>'IndividualController@reject_payment' ]);
		Route::post('{typeId}/profile/{id}/reject/{pid}', [ 'as' => 'backendIndividualRejectById', 'uses'=>'IndividualController@store_reject_payment' ]);
		Route::get('{typeId}/profile/{id}/accept/{pid}', [ 'as' => 'backendIndividualAcceptById', 'uses'=>'IndividualController@accept_payment' ]);
		Route::get('{typeId}/profile/{id}/proof/{nid}', [ 'as' => 'backendIndividualProofById', 'uses'=>'IndividualController@view_proof' ]);
		Route::get('{typeId}', [ 'as' => 'backendIndividual', 'uses'=>'IndividualController@index' ]);
		Route::get('/', [ 'as' => 'backendIndividualHome', 'uses'=>'AdminDashboardController@index' ]);
	});

});

Route::get('register/{entity}', [
		'as'=>'register', 'uses'=>'RegisterController@create'
]);
Route::post('register/getresource/{resource}', 'RegisterController@getResource');
Route::post('register/{entity}', 'RegisterController@store');

// all the routes for front-end site
Route::get('/', function () {
	return View('frontend.index');

});

// all the routes for front-end site
Route::get('/home', function () {
	return View('frontend.index');

});

// all the routes for front-end site
Route::get('/sample', ['as' => 'sample', 'uses' => function () {
	return View('frontend.sample-list');

}]);


// Authentication routes...
Route::get('login', ['middleware' =>['guest'] ,'uses' => 'Auth\AuthController@getLogin']);
Route::get('logout', 'Auth\AuthController@getLogout');

// Authentication routes...
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('/dashboard', ['middleware'=>'auth', 'uses'=>'UserDashboardController@index']);	


// //New Routes User Side Event

Route::group(['prefix' => 'events'], function(){

	Route::group(['prefix' => 'my-events', 'middleware'=>'auth'], function(){

		//filtering
		Route::get('/show-subscribers/{id}/filter', [ 'as' => 'subscriberFilters', 'uses'=>'EventController@subscribersFilter' ]);
		Route::get('filter', [ 'as' => 'myEventFilters', 'uses'=>'EventController@listMyEvents' ]);
		

		Route::get('/', [ 'as' => 'myEventList', 'uses'=>'EventController@listMyEvents' ]);
		Route::get('/{id}', [ 'as' => 'myEvents', 'uses'=>'EventController@showMyEvent' ]);
		Route::get('edit/{id}', [ 'as' => 'editEvent', 'uses'=>'EventController@editEventFormLoad' ]);
		Route::post('edit/{id}', [ 'as' => 'editEvent', 'uses'=>'EventController@editEvent' ]);
		Route::post('cancel-request/{id}', [ 'as' => 'cancelEventRequest', 'uses'=>'EventController@cancelEventRequest' ]);
		Route::get('show-subscribers/{id}', [ 'as' => 'showSuscribers', 'uses'=>'EventController@showSuscribers' ]);
		Route::post('add-post/{id}', [ 'as' => 'addPost', 'uses'=>'EventController@addPost' ]);
		Route::post('edit-grant/{id}', [ 'as' => 'editGrant', 'uses'=>'EventController@editGrant' ]);
		Route::get('remove-grant/{id}', [ 'as' => 'removeGrant', 'uses'=>'EventController@removeGrant' ]);
	});


	Route::get('/guest', ['as' => 'guestViewAll', 'uses' => 'EventController@viewAllEvents' ]);
	Route::get('details/{id}', [ 'as' => 'eventDetails', 'uses'=>'EventController@eventDetails']);
	Route::get('/csi-organisation-subscriber/{id}', ['as'=>'viewCsiOrganisationSubscriber', 'uses'=>'EventController@csiOrganisationSubscriberLoad']);
	Route::get('/organisation-subscriber/{id}', ['as'=>'viewOrganisationSubscriber', 'uses'=>'EventController@organisationSubscriberLoad']);
	Route::post('/csi-organisation-subscriber/{id}', ['as'=>'storeCsiOrganisationSubscriber', 'uses'=>'EventController@storeCsiOrganisationSubscriber']);
	Route::post('/organisation-subscriber/{id}', ['as'=>'storeOrganisationSubscriber', 'uses'=>'EventController@storeOrganisationSubscriber']);

	Route::get('/non-csi-indi-subscribe/{id}', ['as' => 'nonCsiIndiSubscribe', 'uses' => 
		function ($id)
	    {
	        return view('frontend.events.nonCsiSubscriberDetails',compact('id'));
	    }
     ]);
	Route::post('/non-csi-indi-subscribe/{id}', ['as' => 'nonCsiIndiSubscribe', 'uses' => 'EventController@storeNonCsiIndiSubscriber' ]);

	Route::get('/', ['as' => 'memberViewAll', 'uses' => 'EventController@viewAllEvents' ]);
	Route::get('/create', ['as' => 'createEvent', 'uses'=>'EventController@create']);
	Route::post('/create', ['as' => 'createEvent', 'uses'=>'EventController@store']);
	Route::get('/csi-indi-subscriber/{id}', ['as' => 'CsiIndiSubscribe', 'uses'=>'EventController@storeCsiIndiSubscriber']);
	Route::get('/show-nominees/{id}/csi', ['as' => 'showNomineesCSI', 'uses'=>'EventController@showNomineeDetailsCSI']);
	Route::get('/show-nominees/{id}/organisation', ['as' => 'showNomineesORG', 'uses'=>'EventController@showNomineeDetailsORG']);

	Route::get('logo/{filename}', ['as' => 'eventLogo', 'uses' => function($filename){
	    $path = storage_path() . '/uploads/events/logos/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]);

	Route::get('banners/{filename}', ['as' => 'eventBanner', 'uses' => function($filename){
	    $path = storage_path() . '/uploads/events/banners/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]);



	Route::get('pdfs/{filename}', ['as' => 'eventPDF', 'uses' => function($filename){
	    $path = storage_path() . '/uploads/events/pdfs/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]);



	Route::get('post_images/{filename}', ['as' => 'eventPost', 'uses' => function($filename){
	    $path = storage_path() . '/uploads/events/post_images/' . $filename;

	    $file = File::get($path);
	    $type = File::mimeType($path);

	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);

	    return $response;
	}]);
});


Route::group(['prefix' => 'events', 'middleware'=>'auth'], function(){
	
});





Route::get('/profile', ['middleware'=>'auth', 'as' => 'profile', 'uses'=>'UserDashboardController@showProfile']);
Route::get('/confirmStudentBranch', ['middleware'=> ['auth', 'isacademic'], 'as' => 'confirmStudentBranch', 'uses'=>'UserDashboardController@confirmStudentBranch']);
Route::post('/makeStudentBranch', ['middleware'=> ['auth', 'isacademic'], 'uses'=>'UserDashboardController@makeStudentBranch']);
Route::get('/card', ['middleware'=>'auth.individual', 'as' => 'card', 'uses'=>'UserDashboardController@showCard']);


//Handled by modal-
//Route::get('/myEvents/{id}/addPost', ['middleware'=>'auth', 'as' => 'addPost', 'uses'=>'EventController@addPost']);
//Route::get('/allEvents/{id}/addPost', ['middleware'=>'auth', 'as' => 'addPost', 'uses'=>'EventController@addPost']);



// Registration routes...
// Route::group(['prefix' => 'admin'], function() {
// 	// Authentication routes...
	

// 	// Registration routes...
// 	//Route::get('auth/register', 'Auth\AdminAuthController@getRegister');
// 	//Route::post('auth/register', 'Auth\AdminAuthController@postRegister');
	
	
// });
// Registration routes...
// Route::get('/dashboard', ['middleware' => 'auth' ,'uses' => 'UserDashboardController@index']);