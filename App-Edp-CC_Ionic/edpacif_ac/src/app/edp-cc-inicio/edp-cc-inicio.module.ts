import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcInicioPageRoutingModule } from './edp-cc-inicio-routing.module';

import { EdpCcInicioPage } from './edp-cc-inicio.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcInicioPageRoutingModule
  ],
  declarations: [EdpCcInicioPage]
})
export class EdpCcInicioPageModule {}
