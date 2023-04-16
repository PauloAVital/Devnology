@extends('layouts.app')

@section('content')
<style>
    .container img {
        max-width:200px;
        max-height:150px;
        width: auto;
        height: auto;
    }
    .card-titles {
        width: 13rem; 
        float: left; 
        margin-right: 1%
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card col-md-12">
                <div class="card-header">

                    <div class="card card-titles">
                        <img class="card-img-top" src="img/api.jpg" alt="dashboard">
                    </div>
                    <b>End-point para inserção de dados</b>
                    <p class="card-text">VERBO POST.</p>
                    <hr>
                    <b>End-point para consulta de dados de uma api e apis relacionadas</b>
                    <p class="card-text">VERBO GET.</p>
                    <p class="card-text">VERBO GET.Relation</p>
                    <hr>
                    <b>End-point para atualizar dados</b>
                    <p class="card-text">VERBO PUT.</p>
                    <hr>
                    <b>End-point para deletar dados</b>
                    <p class="card-text">VERBO DELETE.</p>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
@endsection