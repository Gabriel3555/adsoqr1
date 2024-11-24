(function(){

    let cargarUsuarios = ()=>{
        let objUsuario = new Usuario({"listarUsuarios":"ok"});
        objUsuario.listarUsuarios();
    }
    cargarUsuarios();

})()