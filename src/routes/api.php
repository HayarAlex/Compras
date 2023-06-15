<?php
/**
 * API ROUTES
 */
Route::get('actives', 'Api\ActiveApiController@actives');
Route::get('config/concepts', 'Api\ConfigApiController@concept');
Route::post('upload', 'Api\ActiveApiController@upload');
Route::post('uploads', 'Api\ActiveApiController@uploads');

//--concepts
Route::get('config/unit', 'Api\ConfigApiController@units');
Route::get('config/employe', 'Api\ConfigApiController@employes');
Route::get('config/asset', 'Api\ConfigApiController@assets');
