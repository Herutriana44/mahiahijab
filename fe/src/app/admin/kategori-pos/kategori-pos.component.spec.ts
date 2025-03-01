import { ComponentFixture, TestBed } from '@angular/core/testing';

import { KategoriPosComponent } from './kategori-pos.component';

describe('KategoriPosComponent', () => {
  let component: KategoriPosComponent;
  let fixture: ComponentFixture<KategoriPosComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [KategoriPosComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(KategoriPosComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
