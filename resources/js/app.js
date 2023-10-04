import './bootstrap';

import Alpine from 'alpinejs';

window.Echo.private('orders')
   .listen('.order.created',function(event){
      alert(`new order created ${event.order.number} `)
   })

window.Alpine = Alpine;

Alpine.start();

