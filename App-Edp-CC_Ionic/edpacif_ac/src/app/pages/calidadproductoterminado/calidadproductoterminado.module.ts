import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { CalidadproductoterminadoPageRoutingModule } from './calidadproductoterminado-routing.module';

import { CalidadproductoterminadoPage } from './calidadproductoterminado.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    CalidadproductoterminadoPageRoutingModule
  ],
  declarations: [CalidadproductoterminadoPage]
})
export class CalidadproductoterminadoPageModule {}
