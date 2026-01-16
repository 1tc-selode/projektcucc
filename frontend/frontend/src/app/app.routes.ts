import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { Dashboard } from './components/dashboard/dashboard';
import { Courses } from './components/courses/courses';
import { Students } from './components/students/students';
import { Instructors } from './components/instructors/instructors';
import { Contact } from './components/contact/contact';
import { About } from './components/about/about';


export const routes: Routes = [
  { path: 'dashboard', component: Dashboard },
  { path: 'courses', component: Courses },
  { path: 'students', component: Students },
  { path: 'instructors', component: Instructors },
  { path: 'contact', component: Contact },
  { path: 'about', component: About },
  { path: '', redirectTo: 'dashboard', pathMatch: 'full' }
];
