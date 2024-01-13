import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcMenucabezascargadasPageRoutingModule } from './edp-cc-menucabezascargadas-routing.module';

import { EdpCcMenucabezascargadasPage } from './edp-cc-menucabezascargadas.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcMenucabezascargadasPageRoutingModule
  ],
  declarations: [EdpCcMenucabezascargadasPage]
})
export class EdpCcMenucabezascargadasPageModule {}
