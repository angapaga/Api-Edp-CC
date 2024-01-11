import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcPanelsaborPageRoutingModule } from './edp-cc-panelsabor-routing.module';

import { EdpCcPanelsaborPage } from './edp-cc-panelsabor.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcPanelsaborPageRoutingModule
  ],
  declarations: [EdpCcPanelsaborPage]
})
export class EdpCcPanelsaborPageModule {}
