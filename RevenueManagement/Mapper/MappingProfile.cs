using AutoMapper;
using RevenueManagement.Models.DTOs.User;
using RevenueManagement.Models.Entities;

namespace RevenueManagement.Mapper
{
    public class MappingProfile : Profile
    {
        public MappingProfile()
        {
            CreateMap<User, UserDto>().ReverseMap();
        }
    }
}
