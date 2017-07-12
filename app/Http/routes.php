<?php
	
Route::match(['get', 'post'], '/manifestacao/{ano}/{idmanifestacao}/prestador.html', 
    [ 'as' => 'respostaprestador', 'uses' => 'RespostaManifestacaoController@login']);
Route::match(['get', 'post'], '/manifestacao/{ano}/{idmanifestacao}/respostaprestador.html', 
    [ 'as' => 'respostaprestador', 'uses' => 'RespostaManifestacaoController@respostaprestador']);



Route::match(['get', 'post'], '/', 
    [ 'as' => 'logar', 'uses' => 'LoginController@index']);
Route::match(['get', 'post'], '/login', 
    [ 'as' => 'authlogin', 'uses' => 'LoginController@index']);
Route::match(['get', 'post'], '/auth/login', 
    [ 'as' => 'authlogin', 'uses' => 'LoginController@index']);

Route::match(['get', 'post'], '/teste', 
    [ 'as' => 'mmi', 'uses' => 'ManifestacaoController@teste']);

Route::group([ 'prefix' => '/admin/', 'middleware' => ['auth']], function(){
    
    Route::match(['get', 'post'], '/', 'SistemaController@index',
        [ 'as' => 'admin::home']);
    
    Route::match(['get', 'post'], '/sair', ['uses' => 'SistemaController@sair',
         'as' => 'admin::sair']);
    
    Route::group(['prefix' => '/canais/'], function(){
        Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'CanalController@cadastrar', 
             'as' => 'admin::canais::cadastrar']);
        Route::match(['get', 'post'], '/cadastrar_canal.html', [ 'uses' => 'CanalController@cadastrarCanal', 
             'as' => 'admin::canais::cadastrar_canal']);
        Route::match(['get', 'post'], '/cadastrar_tipo.html', [ 'uses' => 'CanalController@cadastrarManifestacao', 
             'as' => 'admin::canais::cadastrar_tipo']);
        Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'CanalController@buscar', 
             'as' => 'admin::canais::buscar']);
        Route::match(['get', 'post'], '/vincular.html', [ 'uses' => 'CanalController@canalManifestacao', 
             'as' => 'admin::canais::cadastrar_canal_manifestacao']);
        Route::match(['get'], '/buscarcanal.html', [ 'uses' => 'CanalController@buscarcanal', 
             'as' => 'admin::canais::buscarcanal']);
        
        Route::match(['get', 'post'], '/{id}/detalhescanal.html', [ 'uses' => 'CanalController@detalhescanal', 
             'as' => 'admin::canais::detalhescanal']);
        Route::match(['get', 'post'], '/{id}/detalhestipo.html', [ 'uses' => 'CanalController@detalhestipo', 
             'as' => 'admin::canais::detalhestipo']);
        
    });
    
    Route::group(['prefix' => '/tipo/'], function(){
        Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'TipoController@cadastrar', 
             'as' => 'admin::tipo::cadastrar']);
        Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'TipoController@buscar', 
             'as' => 'admin::tipo::buscar']);
        Route::match(['get', 'post'], '/{id}/detalhes.html', [ 'uses' => 'TipoController@detalhes', 
             'as' => 'admin::tipo::detalhes']);
        Route::match(['get', 'post'], '/{id}/excluir.html', [ 'uses' => 'TipoController@excluir', 
             'as' => 'admin::tipo::excluir']);
        
    });
    
    Route::group(['prefix' => '/prazo/'], function(){
        Route::match(['get', 'post'], '/adicionar.html', [ 'uses' => 'TipoController@adicionarprazo', 
             'as' => 'admin::prazo::adicionar']);
        
        Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'TipoController@buscarprazo', 
             'as' => 'admin::prazo::buscar']);
        
        Route::match(['get', 'post'], '/{idtipo}/{idcanal}/detalhes.html', [ 'uses' => 'TipoController@detalhesprazo', 
             'as' => 'admin::prazo::detalhes']);
        
    });

    Route::group(['prefix' => '/empresa/'], function(){
        Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'EmpresaController@cadastrar', 
             'as' => 'admin::empresa::cadastrar']);
        
        Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'EmpresaController@buscar', 
             'as' => 'admin::empresa::buscar']);
        
        Route::match(['get', 'post'], '/{id}/detalhes.html', [ 'uses' => 'EmpresaController@detalhes', 
             'as' => 'admin::empresa::detalhes']);
        
        Route::match(['get', 'post'], '/buscarperfil.html', [ 'uses' => 'EmpresaController@buscarperfil', 
             'as' => 'admin::empresa::buscarperfil']);
        
        Route::group(['prefix' => '/usuario/'], function(){
            Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'EmpresaController@cadastrarusuario', 
                'as' => 'admin::empresa::usuario::cadastrar']);
            
            Route::match(['get', 'post'], '/{id}/detalhes.html', [ 'uses' => 'EmpresaController@detalhesusuario', 
             'as' => 'admin::empresa::usuario::detalhes']);
            
            Route::match(['get', 'post'], '/{id}/excluir.html', [ 'uses' => 'EmpresaController@excluirusuario', 
             'as' => 'admin::empresa::usuario::excluir']);
            
            Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'EmpresaController@buscarusuario', 
                'as' => 'admin::empresa::usuario::buscar']);
        });
        Route::group(['prefix' => '/perfil/'], function(){
            Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'EmpresaController@cadastrarperfil', 
                'as' => 'admin::empresa::perfil::cadastrar']);
            
            Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'EmpresaController@buscarempresaperfil', 
                'as' => 'admin::empresa::perfil::buscar']);
            
            Route::match(['get', 'post'], '/{id}/detalhes.html', [ 'uses' => 'EmpresaController@detalhesempresaperfil', 
                'as' => 'admin::empresa::perfil::detalhes']);
            
        });
        Route::group(['prefix' => '/produto/'], function(){
            Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'EmpresaController@cadastrarproduto', 
                'as' => 'admin::empresa::produto::cadastrar']);
            
            Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'EmpresaController@buscarproduto', 
                'as' => 'admin::empresa::produto::buscar']);
            Route::match(['get', 'post'], '/{id}/excluir.html', [ 'uses' => 'EmpresaController@excluirproduto', 
                'as' => 'admin::empresa::produto::excluir']);
        });
    });
    
    Route::group(['prefix' => '/prestador/'], function(){
        Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'PrestadorController@cadastrar', 
             'as' => 'admin::prestador::cadastrar']);
        
        Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'PrestadorController@buscar', 
             'as' => 'admin::prestador::buscar']);
        
        Route::match(['get', 'post'], '/buscarperfil.html', [ 'uses' => 'PrestadorController@buscarperfil', 
             'as' => 'admin::prestador::buscarperfil']);
        
        Route::group(['prefix' => '/usuario/'], function(){
            Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'PrestadorController@cadastrarusuario', 
                'as' => 'admin::prestador::usuario::cadastrar']);
            
            Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'PrestadorController@buscarusuario', 
                'as' => 'admin::prestador::usuario::buscar']);
            
            Route::match(['get', 'post'], '/{id}/excluir.html', [ 'uses' => 'PrestadorController@excluirusuario', 
                'as' => 'admin::prestador::usuario::excluir']);
        });
        
        Route::group(['prefix' => '/perfil/'], function(){
            Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'PrestadorController@cadastrarperfil', 
                'as' => 'admin::prestador::perfil::cadastrar']);
            
            Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'PrestadorController@buscarprestadorperfil', 
                'as' => 'admin::prestador::perfil::buscar']);
        });
        
        Route::group(['prefix' => '/servico/'], function(){
            Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'PrestadorController@cadastrarservico', 
                'as' => 'admin::prestador::servico::cadastrar']);
            
            Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'PrestadorController@buscarservico', 
                'as' => 'admin::prestador::servico::buscar']);
            
            Route::match(['get', 'post'], '/{id}/detalhes.html', [ 'uses' => 'PrestadorController@detalhesservico', 
                'as' => 'admin::prestador::servico::detalhes']);
            
            Route::match(['get', 'post'], '/{id}/alterar.html', [ 'uses' => 'PrestadorController@alterarservico', 
                'as' => 'admin::prestador::servico::alterar']);
            
            
                    
        });
    });    
    
    Route::group(['prefix' => '/manifestacao/'], function(){
        Route::match(['get', 'post'], '/cadastrar.html', [ 'uses' => 'ManifestacaoController@cadastrar', 
             'as' => 'admin::manifestacao::cadastrar']);
        
        Route::match(['get', 'post'], '/{ano}/{id}/cadastrar-passo2.html', [ 'uses' => 'ManifestacaoController@passo2', 
             'as' => 'admin::manifestacao::passo2']);
        
        Route::match(['get', 'post'], '/{ano}/{id}/cadastrar-passo3.html', [ 'uses' => 'ManifestacaoController@passo3', 
             'as' => 'admin::manifestacao::passo3']);
        
        
        Route::match(['get', 'post'], '/buscarreclamante.html', [ 'uses' => 'ManifestacaoController@buscarreclamante', 
             'as' => 'admin::manifestacao::buscarreclamante']);
        
        Route::match(['get', 'post'], '/buscartipomanifestacao.html', [ 'uses' => 'ManifestacaoController@buscartipomanifestacao', 
             'as' => 'admin::manifestacao::buscartipomanifestacao']);
        
        Route::match(['get', 'post'], '/buscarprodutoempresa.html', [ 'uses' => 'ManifestacaoController@buscarprodutoempresa', 
             'as' => 'admin::manifestacao::buscarprodutoempresa']);
        
        Route::match(['get', 'post'], '/buscaruf.html', [ 'uses' => 'ManifestacaoController@buscaruf', 
             'as' => 'admin::manifestacao::buscaruf']);
        
        Route::match(['get', 'post'], '/buscarlocalidade.html', [ 'uses' => 'ManifestacaoController@buscarlocalidade', 
             'as' => 'admin::manifestacao::buscarlocalidade']);
        
        Route::match(['get', 'post'], '/buscar.html', [ 'uses' => 'ManifestacaoController@buscar', 
             'as' => 'admin::manifestacao::buscar']);
        
        Route::match(['get', 'post'], '/{ano}/{id}/detalhes.html', [ 'uses' => 'ManifestacaoController@detalhes', 
             'as' => 'admin::manifestacao::detalhes']);
        
        Route::match(['get', 'post'], '/reclamantes.html', [ 'uses' => 'ManifestacaoController@reclamantes', 
             'as' => 'admin::manifestacao::reclamante']);
        
        Route::match(['get', 'post'], '/{id}/{ano}/anexo.html', [ 'uses' => 'ManifestacaoController@anexos', 
             'as' => 'admin::manifestacao::anexos']);
        
        Route::match(['get', 'post'], '/{id}/{ano}/concluir.html', [ 'uses' => 'ManifestacaoController@concluir', 
             'as' => 'admin::manifestacao::concluir']);
        
        Route::match(['get', 'post'], '/{id}/{ano}/mensagens.html', [ 'uses' => 'ManifestacaoController@mensagens', 
             'as' => 'admin::manifestacao::mensagens']);
        
        Route::match(['get', 'post'], '/buscarprestador.html', [ 'uses' => 'ManifestacaoController@buscarprestador', 
             'as' => 'admin::manifestacao::buscarprestador']);
        
        Route::match(['get', 'post'], '/manifestacaomensagem.html', [ 'uses' => 'ManifestacaoController@manifestacaomensagem', 
             'as' => 'admin::manifestacao::manifestacaomensagem']);
    });
});