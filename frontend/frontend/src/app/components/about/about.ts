import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-about',
  imports: [CommonModule],
  templateUrl: './about.html',
  styleUrl: './about.css',
})
export class About {
  technologies = [
    { name: 'Angular', version: '19', icon: '🅰️' },
    { name: 'Laravel', version: '11', icon: '🔺' },
    { name: 'TypeScript', version: '5', icon: '📘' },
    { name: 'PHP', version: '8.3', icon: '🐘' },
    { name: 'MySQL', version: '8', icon: '🗄️' },
    { name: 'RxJS', version: '7', icon: '🔄' },
    { name: 'WebSocket', version: 'Laravel Echo', icon: '🔌' },
    { name: 'Tailwind CSS', version: '3', icon: '🎨' }
  ];

  teamMembers = [
    { name: 'Frontend Developer', role: 'Angular & RxJS Specialist', icon: '👨‍💻' },
    { name: 'Backend Developer', role: 'Laravel & API Expert', icon: '👩‍💻' },
    { name: 'Full Stack Developer', role: 'Integration & WebSocket', icon: '🧑‍💻' }
  ];
}
