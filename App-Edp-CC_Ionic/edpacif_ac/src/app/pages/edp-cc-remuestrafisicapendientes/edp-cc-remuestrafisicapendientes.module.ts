import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcRemuestrafisicapendientesPageRoutingModule } from './edp-cc-remuestrafisicapendientes-routing.module';

import { EdpCcRemuestrafisicapendientesPage } from './edp-cc-remuestrafisicapendientes.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcRemuestrafisicapendientesPageRoutingModule
  ],
  declarations: [EdpCcRemuestrafisicapendientesPage]
})
export class EdpCcRemuestrafisicapendientesPageModule {}
