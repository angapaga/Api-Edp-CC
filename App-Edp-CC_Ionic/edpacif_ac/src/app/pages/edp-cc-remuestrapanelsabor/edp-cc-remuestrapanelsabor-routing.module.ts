import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcRemuestrapanelsaborPage } from './edp-cc-remuestrapanelsabor.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcRemuestrapanelsaborPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcRemuestrapanelsaborPageRoutingModule {}
