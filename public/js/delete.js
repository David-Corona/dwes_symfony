'use strict';

(() => {
   window.addEventListener('load', () => {
       let enlacesDelete = document.querySelectorAll('.delete');
       enlacesDelete.forEach((enlace) => {
           enlace.addEventListener('click', function (event) {
               event.preventDefault();
               let url = this.href; //url = "http://symfony.local.producto/1" (si pincho en el prod 1)
               let enlaceActual = this;

               fetch(url, { method: 'DELETE' })
                   .then(response => response.json())
                   .then(data => {
                       // Aqui ya eliminado de la bbdd
                       if (data.eliminado === true) {
                           enlaceActual.parentNode.parentNode.remove(); // elimina el <tr>
                           Swal.fire(
                               '¡Borrado!',
                               'El producto se ha eliminado correctamente.',
                               'success'
                           )
                       }
                   });

               return false;
           });
       });
   });
})();