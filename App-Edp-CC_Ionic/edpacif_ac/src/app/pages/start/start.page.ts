import { Component, OnInit } from '@angular/core';
import { NavController } from '@ionic/angular';

@Component({
  selector: 'app-start',
  templateUrl: './start.page.html',
  styleUrls: ['./start.page.scss'],
})
export class StartPage implements OnInit {

  constructor(private navCtrl: NavController) {}

  ngOnInit() {
    setTimeout(() => {
      // Utiliza el método navigateForward del NavController para ir a la siguiente vista
      this.navCtrl.navigateForward('/login');
    }, 1000); // 5000 milisegundos = 5 segundos
  }

}
