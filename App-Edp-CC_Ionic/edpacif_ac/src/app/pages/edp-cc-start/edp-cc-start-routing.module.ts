import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcStartPage } from './edp-cc-start.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcStartPage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcStartPageRoutingModule {}
