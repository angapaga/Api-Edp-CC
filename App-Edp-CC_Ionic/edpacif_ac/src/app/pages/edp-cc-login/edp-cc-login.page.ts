import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

import { Router } from '@angular/router';
import { ToastController } from '@ionic/angular';
import { PostService } from '../../services/post.service';
import { Storage } from '@ionic/storage';
import { DataService } from "../../services/data.service";
import { Plugins } from '@capacitor/core';

const { Network } = Plugins;
const { Device } = Plugins;

@Component({
  selector: 'app-edp-cc-login',
  templateUrl: './edp-cc-login.page.html',
  styleUrls: ['./edp-cc-login.page.scss'],
})
export class EdpCcLoginPage implements OnInit {

  username: string = '';
  password: string = '';
  menus: any;
  lista: any;
  cod_usua: any;
  private ttt = '';
  movimientos: any = [];
  periods: any = [];
  periodo_prod: any;
  conectado: any = true;
  plataforma: any;

  constructor(
    private router: Router,
    public toastController: ToastController,
    private postPvdr: PostService,
    private storage: Storage,
    private navCtrl: NavController,
    private dataService: DataService
  ) {

  }


  ngOnInit() {
    this.periods = null;
    this.periods = [];
    this.storage.create();
    this.storage.get('session_storage').then((data) => {
      if (data)
        this.router.navigate(['/edp-cc-login']);
    });
    this.username = '';
    this.password = '';
    this.get_dos_periodos();
    //this.ConectadoRed();
  }

  ionViewWillEnter() {
    this.username = '';
    this.password = '';
    this.periods = null;
    this.periods = [];
  }

  async ConectadoRed() {
    try {
      // Verifica el estado de la red
      const status = await Network['getStatus']();

      if (status.connected) {
        // Realiza la solicitud al servidor si hay conexión
        console.log('Connected to the internet');
        this.conectado = true;
      } else {
        // Muestra un mensaje de error si no hay conexión
        this.toast_ok('No hay conexion, verifica si tu Wifi está Encendido', 'danger', 'top')
        this.conectado = false;
      }
    } catch (error) {
      //this.toast_ok('Error al obtener el estado de la red: '+ error,'danger', 'top')
      //console.error('Error al obtener el estado de la red:', error);
    }
  }

  async verificarPlataforma() {
    const info = await Device['getInfo']();
    if (info.platform === 'ios' || info.platform === 'android') {
      //console.log('La aplicación se está ejecutando en un dispositivo móvil.');
      // Lógica específica para dispositivos móviles
      this.plataforma = 'movil';
    } else {
      //console.log('La aplicación se está ejecutando en un navegador.');
      // Lógica específica para navegadores
      this.plataforma = 'navegador';
    }
  }

  async toast_ok(msg: any, color: any, position: any) {

    const toast = await this.toastController.create({
      message: msg,
      duration: 3000,
      color: color,
      position: position
    });
    toast.present();
  }

  get_dos_periodos() {
    this.periods = null;
    this.periods = [];
    return new Promise((resolve, reject) => {

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
            this.toast_ok(data.message, 'danger', 'top')
            //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
          }
        },
        (error) => {
          this.toast_ok("No hay Respuesta del Server Web " + error.message, 'danger', 'top'); // Manejo de errores de la solicitud HTTP
        }
      );
    });
  }


  login() {
    // this.ConectadoRed();
    // if (this.conectado === false && this.plataforma==='movil'){
    //   this.toast_ok('No hay conexion, verifica si tu Wifi está Encendido','danger', 'top')
    //   return new Promise((resolve, reject) => {});
    // }else{
    this.get_dos_periodos();
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
            //this.dataService.setPeriodo(this.periodo_prod);

            this.router.navigate(['/edp-cc-home']);
            this.toast_ok('Bienvenido!!!', 'success', 'top');

          } else {
            this.toast_ok(data.message, 'danger', 'top');
            this.username = '';
            this.password = '';
            this.periods = null;
            this.periods = [];
            //this.presentAlert('', data.result); // Puedes enviar el mensaje de error como argumento a reject
          }
        },
        async (error) => {
          this.toast_ok('Algo Salió Mal!!!' + error.message, 'danger', 'top');

          this.username = '';
          this.password = '';
          this.periods = null;
          this.periods = [];
        },

      );
    });
  }
  // }
}
