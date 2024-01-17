import { Component, OnInit } from '@angular/core';
import { NavController,
        AlertController,
        ToastController } from '@ionic/angular';

import { PostService } from "../../services/post.service"; 
import { Storage } from "@ionic/storage";     
import { Router } from "@angular/router"; 

@Component({
  selector: 'app-edp-cc-panelespendientes',
  templateUrl: './edp-cc-panelespendientes.page.html',
  styleUrls: ['./edp-cc-panelespendientes.page.scss'],
})
export class EdpCcPanelespendientesPage implements OnInit {

  lista_pe:any;
  contar :any;
  total :any;
  sesion:any;
  cedula:any;
  cod_usua:any;
  username:any;
  cod_asignacion:any;
  periodo:any;
  cabecera:any;
  constructor(private navCtrl: NavController, 
              private toastController: ToastController,
              private alertController: AlertController,
              private postPvdr: PostService,
              private storage: Storage,
              private router: Router) { }

  ngOnInit() {
    this.storage.create();
    this.storage.get('session_storage').then((res) => {
      this.sesion = res; 
      this.storage.get('periodo').then((res) => {
        this.periodo = res; 
          this.storage.get('cabecera_panel').then((res) => {
            this.cabecera = res; 
            this.mostrar_pe();
          //console.log(this.cabecera);
          }); 

          this.cedula = this.sesion[0].usua_cod_empl;
          this.cod_usua = this.sesion[0].cod_usua;
          this.username = this.sesion[0].username;
          //console.log(this.username);
    });
  });
  }

  regresar() {
    // Utiliza el método pop() del NavController para regresar a la página anterior
    this.navCtrl.pop();
  }

  ionViewWillEnter() {
    //this.mostrar_pe();
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

async presentAlert(header:string, msg:string) {

  const alert = await this.alertController.create({
    cssClass: 'msg',
    header: header,
    message: msg,
    buttons: ['OK']
  });

  await alert.present();
  
}


mostrar_pe() {
  return new Promise((resolve, reject) => {
    this.lista_pe = null;
    this.lista_pe = [];

    let body = {
      peticion: "cabecera_panel_estado",
      cod_usua: this.cod_usua,
      estado: "PE",
      periodo: this.periodo,
      empleado: this.cedula
    };

    this.postPvdr.postData(body, 'Api-Edp-CC-Aseg-Calidad.php').subscribe(
      (data: any) => {

        //console.log(data.result[0]);
        this.contar=0;
        if (data.code == 200) {
          for (let get_lista of data.result) {
            this.lista_pe.push(get_lista);
            this.contar = this.contar +1;
          }
          resolve(this.lista_pe);
          this.total = this.lista_pe.length;
        } else {
          this.toast_ok(data.result,'danger', 'middle')
          //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
        }
      },
      (error) => {
        reject("Error en la solicitud HTTP"); // Manejo de errores de la solicitud HTTP
      }
    );
  });
}

editar_doc(cabecera:any){
  this.toast_ok('Panel de sabores está en etapa de pruebas', 'danger','middle');
  // this.storage.set('cabecera_panel', cabecera);
  // this.router.navigate(['/edp-cc-remuestrapanelsabor']);
}



}
