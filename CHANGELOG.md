# Changelog

## Version 0.*

* v0.3.0 (TBD)

  * introduced Decorator for easy callbacks on before and after method call and property manipulation events
  * introduced InterfaceType for checking if given class or object implements configured interface
  * introduced AliasType for registering custom types with overridden aliases, for example for multiple class checks

* v0.2.0 (24.11.2014)

  * rewritten library
  * all types now live in separate classes and can be registered separately
  * introduced matching strategies for better flexibility, three available by default (All, Single, AtLeast)
  * renamed types to less verbose names, type-like values referenced by @ prefix, array by [] postfix
  * updated README reflecting those changes

* v0.1.0 (12.11.2014)

  * first library version with set of helpers as public methods
