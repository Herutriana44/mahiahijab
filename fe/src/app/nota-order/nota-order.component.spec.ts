import { ComponentFixture, TestBed } from '@angular/core/testing';

import { NotaOrderComponent } from './nota-order.component';

describe('NotaOrderComponent', () => {
  let component: NotaOrderComponent;
  let fixture: ComponentFixture<NotaOrderComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [NotaOrderComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(NotaOrderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
