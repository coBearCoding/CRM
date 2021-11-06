<template>
    <div class="header-dots">
        <div class="dropdown">
            <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown"
                    class="p-0 mr-2 btn btn-link">
                    <span class="icon-wrapper icon-wrapper-alt rounded-circle">
                        <span class="icon-wrapper-bg bg-danger"></span>
                        <i class="icon text-danger icon-anim-pulse ion-android-notifications"></i>
                        <span class="badge badge-dot badge-dot-sm badge-danger">Notificaciones</span>
                    </span>
            </button>
            <div tabindex="-1" role="menu" aria-hidden="true"
                 class="dropdown-menu-xl rm-pointers dropdown-menu dropdown-menu-right">
                <div class="dropdown-menu-header mb-0">
                    <div class="dropdown-menu-header-inner bg-deep-blue">
                        
                        <div class="menu-header-content text-dark">
                            <h5 class="menu-header-title">Notificaciones</h5>
                            
                                <h6 class="menu-header-subtitle">Tienes <b>{{notifications.length}}</b> notificaciones no leídas</h6>
                           
                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-messages-header" role="tabpanel">
                        <div class="scroll-area-sm">
                            <div class="scrollbar-container ps">
                                <div class="p-3">
                                    <div class="notifications-box">
                                        <div class="vertical-time-simple vertical-without-time vertical-timeline vertical-timeline--one-column">

                                          
                                         

                                           <div  v-for="notification in notifications">
                                                <div class="vertical-timeline-item dot-danger vertical-timeline-element">
                                                    <div >
                                                        <span class="vertical-timeline-element-icon bounce-in"></span>
                                                        <div class="vertical-timeline-element-content bounce-in">
                                                           <p > Se te asigno el lead <b>{{ notification.data.contacto.nombre }}</b>, con el correo <b>{{ notification.data.contacto.correo }}</b> <br><b class="text-danger text-right"><timeago :datetime="notification.data.contacto_historico_last.created_at" :auto-update="60"></timeago></b></p>  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                                    <div class="ps__thumb-x" tabindex="0"
                                         style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps__rail-y" style="top: 0px; right: 0px;">
                                    <div class="ps__thumb-y" tabindex="0"
                                         style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>


</template>


<script>
	import VueTimeago from 'vue-timeago'

    Vue.use(VueTimeago, {
      name: 'Timeago', // Component name, `Timeago` by default
      locale: 'es', // Default locale
      // We use `date-fns` under the hood
      // So you can use all locales from it
      locales: {
        'es': require('date-fns/locale/es'),
        ja: require('date-fns/locale/es')
      }
    });

    export default {

    	props: ['user_id'],

    	data(){
    		return{
    			notifications:[]
    		}
    	},
        mounted() {
        	axios.post('notificaciones').then(res=>{
        		console.log(res.data);
        		this.notifications = res.data;
        		console.log(this.notifications)
        	});
        	window.Echo.channel('leads')
		    	.listen('CrmEvents',(data)=>{
		    		console.log('realtime');
		    		console.log(this.notifications)
		    		console.log(data.data.contacto_historico_last.vendedor_id)
		    		if (this.user_id == data.data.contacto_historico_last.vendedor_id) {
                        var sonido = new Audio("/sound/notificacion.mp3");
                        sonido.play();
		    			this.notifications.unshift(data);
		    			console.log(this.notifications);
                        toastr.success('Se asigno un nuevo leads');

		    		}
		    	});
            console.log('Component mounted.')
        }
    }
</script>