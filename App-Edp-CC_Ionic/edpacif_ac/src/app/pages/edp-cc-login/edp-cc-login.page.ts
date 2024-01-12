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
     //this.get_periodo();
 
   }
 
   ionViewWillEnter() {
     this.username ='';
     this.password= '';
   }

   get_periodo() {
    this.periods=[];
    return new Promise(resolve => {
      let body = {
        api: 'get_periodos'
      };


      this.postPvdr.postData(body, 'api_clasificadora.php').subscribe(data => {
        if(data.success){
        for (let period of data.result) {
          this.periods.push(period);
          
        }
        resolve(true);
        
       }
      }); 
    });
  }

 

  login(){
    //his.navCtrl.navigateForward('/edp-cc-home');


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
            //this.storage.set('periodo', this.periodo_prod);

            this.router.navigate(['/edp-cc-home']);
            const toast = await this.toastController.create({
              message: 'Bienvenido!',
              duration: 3000,
              color: 'success',
              position:'top'


            });
            toast.present();
          } else {
            const toast = await this.toastController.create({
              message: data.message,
              duration: 3000,
              color:'danger',
              position: 'top'
            });
            toast.present();
            //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
          }
        },
        async (error) => {
          const toast = await this.toastController.create({
            message: 'Algo salió mal',
            duration: 3000,
            color:'danger',
            position: 'top'
          });
          toast.present();
          
          this.username ='';
          this.password= '';
        }
      );
    });
  }

}
