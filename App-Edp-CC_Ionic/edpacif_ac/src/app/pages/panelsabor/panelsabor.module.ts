import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { PanelsaborPageRoutingModule } from './panelsabor-routing.module';

import { PanelsaborPage } from './panelsabor.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    PanelsaborPageRoutingModule
  ],
  declarations: [PanelsaborPage]
})
export class PanelsaborPageModule {}
