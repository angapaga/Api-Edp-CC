import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

import { EdpCcHomePage } from './edp-cc-home.page';

const routes: Routes = [
  {
    path: '',
    component: EdpCcHomePage
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
})
export class EdpCcHomePageRoutingModule {}
