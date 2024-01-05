import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-edp-cc-start',
  templateUrl: './edp-cc-start.page.html',
  styleUrls: ['./edp-cc-start.page.scss'],
})
export class EdpCcStartPage implements OnInit {

  constructor(private navCtrl: NavController) {}

  ngOnInit() {
    setTimeout(() => {
      // Utiliza el método navigateForward del NavController para ir a la siguiente vista
      this.navCtrl.navigateForward('/edp-cc-login');
    }, 1000); // 5000 milisegundos = 5 segundos
  }

}
