import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcCabezascargadaspendientesPageRoutingModule } from './edp-cc-cabezascargadaspendientes-routing.module';

import { EdpCcCabezascargadaspendientesPage } from './edp-cc-cabezascargadaspendientes.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcCabezascargadaspendientesPageRoutingModule
  ],
  declarations: [EdpCcCabezascargadaspendientesPage]
})
export class EdpCcCabezascargadaspendientesPageModule {}
