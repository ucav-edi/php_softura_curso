$(document).ready(function () {

    var Catalogos = {
        html_cat_cont : '',
        obtener_cat_estado : function () {
            $.ajax({
                type : 'post',
                url : 'http://localhost/php_puro_softura-main_1/rutas/empleados.php?peticion=catalogos&funcion=estado',
                data : {},
                dataType : 'json',
                success : function (respAjax){
                    if (respAjax.success){
                        var html_list_est = '<option value="">--Selecione Estado</option>'
                        respAjax.data.catalogo_estado.forEach(function (elemento) {
                            html_list_est += '<option value="'+elemento.id+'">'+elemento.nombre+'</option>';

                        });
                        $('#inputListaEstado').html(html_list_est);
                    }

                },error : function (err) {
                    alert('error al listar el catalogo');
                }
            })
        },

        obtener_cat_cont : function () {
            $.ajax({
                type : 'post',
                url : 'http://localhost/php_puro_softura-main_1/rutas/empleados.php?peticion=catalogos&funcion=contacto',
                data : {},
                dataType : 'json',
                success : function (respAjax){
                    if (respAjax.success){
                        var html_list_cont = '<option value="">--Selecione contacto</option>'
                        respAjax.data.catalogo_contacto.forEach(function (elemento) {
                            html_list_cont += '<option value="'+elemento.id+'">'+elemento.tipo+'</option>';

                        });
                        Catalogos.html_cat_cont = html_list_cont;
                    }

                },error : function (err) {
                    alert('error al listar el catalogo');
                }
            })
        }

    }
    //Catalogos.obtener_cat_cont();
    Catalogos.obtener_cat_cont();
    Catalogos.obtener_cat_estado();

})