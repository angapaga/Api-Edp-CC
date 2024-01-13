import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { PostService } from '../../services/post.service';
import { Storage } from '@ionic/storage';


@Component({
  selector: 'app-edp-cc-login',
  templateUrl: './edp-cc-login.page.html',
  styleUrls: ['./edp-cc-login.page.scss'],
})
export class EdpCcLoginPage implements OnInit {

  username: string = '';
  password: string = '';
  menus:any;
  lista:any;
  cod_usua:any;
  private ttt = '';
  movimientos: any = [];
  periods: any = [];
  periodo_prod :any;
 
   constructor(
     private router: Router,
     public toastController: ToastController,
     private postPvdr: PostService,
     private storage: Storage,
     private navCtrl: NavController
     ) { 
         
     }
 
   ngOnInit() {
    this.storage.create();
     this.storage.get('session_storage').then((data)=>{
       if(data)
         this.router.navigate(['/edp-cc-login']);
     });
     this.username ='';
     this.password= '';
     this.get_dos_periodos();
 
   }
 
   ionViewWillEnter() {
     this.username ='';
     this.password= '';
   }

   async toast_ok(msg:any,color:any, position:any){
  
      const toast = await this.toastController.create({
      message: msg,
      duration: 3000,
      color : color,
      position: position
    });
      toast.present();
  }

  get_dos_periodos() {
    return new Promise((resolve, reject) => {
      this.periods = null;
      this.periods = [];
  
      let body = {
        peticion: "Dos_periodos_activos"
      };
  
      this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
        (data: any) => {

          if (data.code == 200) {
            for (let period of data.result) {
              this.periods.push(period);
            }
            resolve(this.periods);
          } else {
            this.toast_ok(data.result,'danger', 'top')
            //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
          }
        },
        (error) => {
          reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
        }
      );
    });
  }
 

  login(){
    return new Promise((resolve, reject) => {
      this.lista = null;
      this.lista = [];
  
      let body = {
        cod_usua: this.username,
        pass: this.password,
        peticion: 'iniciar',
        periodo: this.periodo_prod
      };
  
      this.postPvdr.postData(body, 'Api-Edp-CC-Login.php').subscribe(
        async (data: any) => {
          if (data.code == 200) {
            for (let get_lista of data.result) {
              this.lista.push(get_lista);

            }
            resolve(this.lista);
            this.storage.set('session_storage', data.result);
            this.storage.set('periodo', this.periodo_prod);

            this.router.navigate(['/edp-cc-home']);
            this.toast_ok('Bienvenido!!!','success', 'top');

          } else {
            this.toast_ok(data.message,'danger', 'top');
            //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
          }
        },
        async (error) => {
          this.toast_ok('Algo Salió Mal!!!','danger', 'top');
          
          this.username ='';
          this.password= '';
        }
      );
    });
  }

}
