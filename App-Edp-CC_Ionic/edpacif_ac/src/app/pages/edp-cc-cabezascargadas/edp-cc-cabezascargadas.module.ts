import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcCabezascargadasPageRoutingModule } from './edp-cc-cabezascargadas-routing.module';

import { EdpCcCabezascargadasPage } from './edp-cc-cabezascargadas.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcCabezascargadasPageRoutingModule
  ],
  declarations: [EdpCcCabezascargadasPage]
})
export class EdpCcCabezascargadasPageModule {}
