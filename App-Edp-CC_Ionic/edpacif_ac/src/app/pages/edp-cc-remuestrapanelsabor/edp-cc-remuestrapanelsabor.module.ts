import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';

import { IonicModule } from '@ionic/angular';

import { EdpCcRemuestrapanelsaborPageRoutingModule } from './edp-cc-remuestrapanelsabor-routing.module';

import { EdpCcRemuestrapanelsaborPage } from './edp-cc-remuestrapanelsabor.page';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    EdpCcRemuestrapanelsaborPageRoutingModule
  ],
  declarations: [EdpCcRemuestrapanelsaborPage]
})
export class EdpCcRemuestrapanelsaborPageModule {}
